<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\ScreeningResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScreeningController extends Controller
{


    public function show($type)
    {
        $depressionQs = Question::where('type', 'depression')->orderBy('order')->get();
        $anxietyQs = Question::where('type', 'anxiety')->orderBy('order')->get();
        $impactQ = Question::where('type', 'impact')->first(); // Ambil 1 soal dampak

        return view('student.screening.form', compact(
            'depressionQs',
            'anxietyQs',
            'impactQ',
            'type'
        ));
    }

    // Fungsi pembantu untuk menentukan kategori & rekomendasi sesuai rentang skor
    private function getInterpretation($score)
    {
        if ($score >= 20) {
            return ['cat' => 'Berat (Severe)', 'rec' => 'Intervensi medis/psikiatri segera diperlukan.'];
        } elseif ($score >= 15) {
            return ['cat' => 'Sedang-Berat', 'rec' => 'Sangat disarankan mencari bantuan profesional segera.'];
        } elseif ($score >= 10) {
            return ['cat' => 'Sedang (Moderate)', 'rec' => 'Disarankan berkonsultasi dengan konselor atau psikolog.'];
        } elseif ($score >= 5) {
            return ['cat' => 'Ringan (Mild)', 'rec' => 'Edukasi mandiri, meditasi, dan pemantauan berkala.'];
        } else {
            return ['cat' => 'Minimal/Normal', 'rec' => 'Menjaga gaya hidup sehat dan istirahat cukup.'];
        }
    }

    public function store(Request $request, $type)
    {
        $data = $request->all();
        $userId = Auth::id();

        // 1. SKOR DEPRESI (9 Soal)
        $depressionQs = Question::where('type', 'depression')->get();
        $depressionScore = 0;
        $depressionDetails = [];
        $isHighRisk = false; // Trigger Kritis

        foreach ($depressionQs as $q) {
            $val = (int) ($data['q_' . $q->id] ?? 0);
            $depressionScore += $val;
            $depressionDetails[$q->id] = $val;

            // Trigger Logika Penilaian Tambahan (Soal No 9 / ID 9)
            if ($q->id == 9 && $val >= 1) {
                $isHighRisk = true;
            }
        }
        $depResult = $this->getInterpretation($depressionScore);

        // 2. SKOR KECEMASAN (7 Soal)
        $anxietyQs = Question::where('type', 'anxiety')->get();
        $anxietyScore = 0;
        $anxietyDetails = [];

        foreach ($anxietyQs as $q) {
            $val = (int) ($data['q_' . $q->id] ?? 0);
            $anxietyScore += $val;
            $anxietyDetails[$q->id] = $val;
        }
        $anxResult = $this->getInterpretation($anxietyScore);

        // 3. PERTANYAAN DAMPAK (ID 17)
        $impactQ = Question::where('type', 'impact')->first();
        $impactScore = $impactQ ? (int) ($data['q_' . $impactQ->id] ?? 0) : null;
        
        // Pemetaan teks jawaban dampak untuk disimpan agar mudah dibaca
        $impactOptions = [0 => 'Tidak sulit sama sekali', 1 => 'Agak sulit', 2 => 'Sangat sulit', 3 => 'Sangat sulit sekali'];
        $impactText = $impactOptions[$impactScore] ?? 'Tidak terjawab';

        // SIMPAN DATA
        ScreeningResponse::create([
            'user_id' => $userId,
            'type' => $type,
            'score' => $depressionScore + $anxietyScore,
            'category' => "Depresi: {$depResult['cat']} | Kecemasan: {$anxResult['cat']} " . ($isHighRisk ? "[! RISIKO TINGGI !]" : ""),
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
                    'text_answer' => $impactText
                ]
            ]),
        ]);

        return redirect()->route('student.dashboard')->with('success', 'Terima kasih, kuesioner telah tersimpan. Silakan cek hasil evaluasi Anda.');
    }
}