<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\ScreeningResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScreeningController extends Controller
{


    public function index()
    {
        $userId = Auth::id();
        
        // Ambil riwayat evaluasi (kuesioner) student ini, urutkan dari yang terbaru
        $history = ScreeningResponse::where('user_id', $userId)
                                    ->orderBy('created_at', 'desc')
                                    ->get();

        // Cek apakah hari ini (GMT+7) sudah pernah tes
        $today = now()->timezone('Asia/Jakarta')->startOfDay();
        $hasTakenToday = ScreeningResponse::where('user_id', $userId)
                                            ->where('created_at', '>=', $today)
                                            ->exists();
        
        $canTakeTest = !$hasTakenToday;

        // Data Grafik (Ambil 7 data terakhir, urutkan chronological untuk chart)
        $chartDataRaw = ScreeningResponse::where('user_id', $userId)
                                        ->orderBy('created_at', 'asc')
                                        ->take(30) // Tampilkan max 30 titik untuk grafik
                                        ->get();
        
        $chartLabels = [];
        $chartScores = [];

        foreach($chartDataRaw as $data) {
            $chartLabels[] = $data->created_at->timezone('Asia/Jakarta')->format('d M Y H:i');
            $chartScores[] = $data->score;
        }

        $viewPrefix = 'student';
        if (Auth::user()->role === 'admin') {
            $viewPrefix = 'admin';
        } elseif (Auth::user()->sub_role === 'lecturer') {
            $viewPrefix = 'lecturer';
        }

        // Calculate dynamic thresholds for view coloring (based on depression + anxiety)
        $depressionAnxietyQs = Question::whereIn('type', ['depression', 'anxiety'])->count();
        $minScore = $depressionAnxietyQs * 1;
        $maxScore = $depressionAnxietyQs * 4;
        $range = $maxScore - $minScore;
        $moderateThreshold = $minScore + floor($range / 3); 
        $warningThreshold = $minScore + floor(2 * $range / 3); 

        return view($viewPrefix . '.screening.history', compact('history', 'canTakeTest', 'chartLabels', 'chartScores', 'maxScore', 'warningThreshold', 'moderateThreshold'));
    }

    public function show()
    {
        $userId = Auth::id();
        $today = now()->timezone('Asia/Jakarta')->startOfDay();
        $hasTakenToday = ScreeningResponse::where('user_id', $userId)
                                            ->where('created_at', '>=', $today)
                                            ->exists();
        if ($hasTakenToday) {
            $routePrefix = 'student';
            if (Auth::user()->role === 'admin') {
                $routePrefix = 'admin';
            } elseif (Auth::user()->sub_role === 'lecturer') {
                $routePrefix = 'lecturer';
            }
            return redirect()->route($routePrefix . '.screening.index')->with('error', 'Anda sudah melakukan evaluasi hari ini. Silakan kembali besok.');
        }

        $depressionQs = Question::where('type', 'depression')->orderBy('order')->get()->groupBy('subtype');
        $anxietyQs = Question::where('type', 'anxiety')->orderBy('order')->get()->groupBy('subtype');
        $impactQ = Question::where('type', 'impact')->first(); // Ambil 1 soal dampak

        $viewPrefix = 'student';
        if (Auth::user()->role === 'admin') {
            $viewPrefix = 'admin';
        } elseif (Auth::user()->sub_role === 'lecturer') {
            $viewPrefix = 'lecturer';
        }

        return view($viewPrefix . '.screening.form', compact(
            'depressionQs',
            'anxietyQs',
            'impactQ'
        ));
    }

    // Fungsi pembantu untuk menentukan kategori & rekomendasi sesuai rentang skor dinamis
    private function getInterpretation($score, $maxScore, $minScore = 0)
    {
        if ($maxScore == 0) return ['cat' => '-', 'rec' => ''];
        
        $range = $maxScore - $minScore;
        $oneThird = $minScore + floor($range / 3);
        $twoThirds = $minScore + floor(2 * $range / 3);

        if ($score >= $twoThirds) {
            return ['cat' => 'Tinggi', 'rec' => 'Intervensi lebih lanjut disarankan.'];
        } elseif ($score >= $oneThird) {
            return ['cat' => 'Sedang', 'rec' => 'Disarankan berkonsultasi dengan konselor atau psikolog.'];
        } else {
            return ['cat' => 'Ringan', 'rec' => 'Tetap jaga kesehatan mental dan lakukan pemantauan berkala.'];
        }
    }

    public function store(Request $request)
    {
        $userId = Auth::id();
        
        // Double check submission limit if it's the daily test
        $today = now()->timezone('Asia/Jakarta')->startOfDay();
        $hasTakenToday = ScreeningResponse::where('user_id', $userId)
                                            ->where('created_at', '>=', $today)
                                            ->exists();
        if ($hasTakenToday) {
            $routePrefix = 'student';
            if (Auth::user()->role === 'admin') {
                $routePrefix = 'admin';
            } elseif (Auth::user()->sub_role === 'lecturer') {
                $routePrefix = 'lecturer';
            }
            return redirect()->route($routePrefix . '.screening.index')->with('error', 'Evaluasi harian Anda sudah tersimpan sebelumnya.');
        }

        $data = $request->all();

        // 1. SKOR DEPRESI
        $depressionQs = Question::where('type', 'depression')->get();
        $depressionScore = 0;
        $minDepressionScore = $depressionQs->count() * 1;
        $maxDepressionScore = $depressionQs->count() * 4;
        $depressionDetails = [];
        $isHighRisk = false; // Trigger Kritis

        foreach ($depressionQs as $q) {
            $val = (int) ($data['q_' . $q->id] ?? 0);
            $depressionScore += $val;
            $depressionDetails[$q->id] = $val;
        }
        $depResult = $this->getInterpretation($depressionScore, $maxDepressionScore, $minDepressionScore);

        // 2. SKOR KECEMASAN
        $anxietyQs = Question::where('type', 'anxiety')->get();
        $anxietyScore = 0;
        $minAnxietyScore = $anxietyQs->count() * 1;
        $maxAnxietyScore = $anxietyQs->count() * 4;
        $anxietyDetails = [];

        foreach ($anxietyQs as $q) {
            $val = (int) ($data['q_' . $q->id] ?? 0);
            $anxietyScore += $val;
            $anxietyDetails[$q->id] = $val;
        }
        $anxResult = $this->getInterpretation($anxietyScore, $maxAnxietyScore, $minAnxietyScore);

        // 3. PERTANYAAN DAMPAK (ID 17)
        $impactQ = Question::where('type', 'impact')->first();
        $impactScore = $impactQ ? (int) ($data['q_' . $impactQ->id] ?? 0) : null;
        
        // Pemetaan teks jawaban dampak untuk disimpan agar mudah dibaca
        $impactOptions = [0 => 'Tidak sulit sama sekali', 1 => 'Agak sulit', 2 => 'Sangat sulit', 3 => 'Sangat sulit sekali'];
        $impactText = $impactOptions[$impactScore] ?? 'Tidak terjawab';
        $minImpactScore = 0;
        $maxImpactScore = $impactQ ? 3 : 0;
        $impactResult = $impactQ ? $this->getInterpretation($impactScore, $maxImpactScore, $minImpactScore) : null;

        // SIMPAN DATA
        ScreeningResponse::create([
            'user_id' => $userId,
            'score' => $depressionScore + $anxietyScore + ($impactScore ?? 0),
            'category' => "Depresi: {$depResult['cat']} | Kecemasan: {$anxResult['cat']} | Dampak: " . ($impactResult['cat'] ?? '-') . " " . ($isHighRisk ? "[! RISIKO TINGGI !]" : ""),
            'answers_detail' => json_encode([
                'depression' => [
                    'score' => $depressionScore, 
                    'category' => $depResult['cat'], 
                    'recommendation' => $depResult['rec'],
                    'high_risk_trigger' => $isHighRisk,
                    'detail' => $depressionDetails
                ],
                'anxiety' => [
                    'score' => $anxietyScore, 
                    'category' => $anxResult['cat'], 
                    'recommendation' => $anxResult['rec'],
                    'detail' => $anxietyDetails
                ],
                'impact' => [
                    'score' => $impactScore,
                    'category' => $impactResult['cat'] ?? '-',
                    'text_answer' => $impactText
                ]
            ]),
        ]);

        $routePrefix = 'student';
        if (Auth::user()->role === 'admin') {
            $routePrefix = 'admin';
        } elseif (Auth::user()->sub_role === 'lecturer') {
            $routePrefix = 'lecturer';
        }
        
        return redirect()->route($routePrefix . '.screening.index')->with('success', 'Terima kasih, kuesioner telah tersimpan. Silakan cek hasil evaluasi Anda.');
    }
}