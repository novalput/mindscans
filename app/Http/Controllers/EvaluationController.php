<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ScreeningResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class EvaluationController extends Controller
{
    public function index()
    {
        $students = User::where('role', 'student')->with('student')->latest()->paginate(10);
        return view('lecturer.evaluation.index', compact('students'));
    }

    public function show($id)
    {
        $student = User::with(['student', 'screeningResponses'])->findOrFail($id);

        $preTest = $student->screeningResponses->where('type', 'pre_test')->first();
        $postTest = $student->screeningResponses->where('type', 'post_test')->first();

        // Fresh query untuk ambil scan terbaru
        $latestScan = $student->screeningResponses()
            ->where('type', 'gingivitis_scan')
            ->whereNotNull('gingivitis_image')
            ->latest()
            ->first();

        return view('lecturer.evaluation.show', compact('student', 'preTest', 'postTest', 'latestScan'));
    }

    public function printPdf($id)
    {
        $student = User::with(['student', 'screeningResponses'])->findOrFail($id);
        $preTest = $student->screeningResponses->where('type', 'pre_test')->first();
        $postTest = $student->screeningResponses->where('type', 'post_test')->first();

        $latestScan = $student->screeningResponses()
            ->where('type', 'gingivitis_scan')
            ->whereNotNull('gingivitis_image')
            ->latest()
            ->first();

        return view('lecturer.evaluation.print', compact('student', 'preTest', 'postTest', 'latestScan'));
    }

    public function scanGingivitis(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        try {
            $file = $request->file('image');
            $filename = Str::random(25) . '.jpg';
            $path = 'gingivitis_scans/' . $filename;

            // --- 1. PROSES KOMPRESI ---
            $img = Image::make($file->getRealPath());
            $img->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $compressedData = (string) $img->encode('jpg', 70);

            // --- 2. TEMBAK API ROBOFLOW ---
            $apiUrl = "https://detect.roboflow.com/gingivitis-detection-tc9pt-c0xlp/1?api_key=OChuVRQQDhoJ5g3Vq7V1";

            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withHeaders([
                "Content-Type" => "application/x-www-form-urlencoded"
            ])->withBody(base64_encode($compressedData), 'text/plain')->post($apiUrl);

            if ($response->successful()) {
                $predictions = $response->json()['predictions'] ?? [];

                // --- 3. SIMPAN KE DATABASE ---
                ScreeningResponse::create([
                    'user_id'          => $id,
                    'type'             => 'gingivitis_scan',
                    'gingivitis_image' => $path,
                    'detection_result' => json_encode($predictions),
                    'category'         => count($predictions) > 0 ? 'Terdeteksi Gingivitis' : 'Normal',
                ]);

                // Simpan file ke storage SETELAH API sukses
                Storage::disk('public')->put($path, $compressedData);;

                return back()->with('success', 'Analisa Selesai! Ditemukan ' . count($predictions) . ' titik.');
            }

            return back()->with('error', 'Gagal Response AI: ' . $response->status());

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi Kesalahan: ' . $e->getMessage());
        }
    }

    public function updateAdvice(Request $request, $id)
    {
        $request->validate([
            'lecturer_advice' => 'required|string|max:1000',
        ]);

        $scan = ScreeningResponse::findOrFail($id);
        $scan->update([
            'lecturer_advice' => $request->lecturer_advice
        ]);

        return back()->with('success', 'Saran lecturer berhasil disimpan!');
    }
}
