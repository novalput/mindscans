<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\ScreeningResponse;
use Illuminate\Database\Seeder;

class ScreeningResponseSeeder extends Seeder
{
    public function run(): void
    {
        ScreeningResponse::truncate();
        
        $depressionQs = Question::where('type', 'depression')->get();
        $anxietyQs = Question::where('type', 'anxiety')->get();
        $impactQ = Question::where('type', 'impact')->first();

        // Helpers
        $getInterpretation = function($score, $maxScore, $minScore) {
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
        };

        // 1. Dimas (Healthcare Professional, id=4) - Mild (val=1)
        $this->createDummy(4, 1, $depressionQs, $anxietyQs, $impactQ, $getInterpretation);

        // 2. Raka (Patient, id=2) - Moderate (val=2)
        $this->createDummy(2, 2, $depressionQs, $anxietyQs, $impactQ, $getInterpretation);

        // 3. Sinta (Patient, id=5) - High (val=4)
        $this->createDummy(5, 4, $depressionQs, $anxietyQs, $impactQ, $getInterpretation);
    }

    private function createDummy($userId, $val, $depQs, $anxQs, $impactQ, $getInter)
    {
        $depScore = 0;
        $depDetails = [];
        foreach ($depQs as $q) {
            $depScore += $val;
            $depDetails[$q->id] = $val;
        }
        $depMax = $depQs->count() * 4;
        $depMin = $depQs->count() * 1;
        $depRes = $getInter($depScore, $depMax, $depMin);

        $anxScore = 0;
        $anxDetails = [];
        foreach ($anxQs as $q) {
            $anxScore += $val;
            $anxDetails[$q->id] = $val;
        }
        $anxMax = $anxQs->count() * 4;
        $anxMin = $anxQs->count() * 1;
        $anxRes = $getInter($anxScore, $anxMax, $anxMin);

        $impScore = $val == 4 ? 3 : ($val == 2 ? 1 : 0);
        $impMax = 3;
        $impMin = 0;
        $impRes = $getInter($impScore, $impMax, $impMin);
        $impactOptions = [0 => 'Tidak sulit sama sekali', 1 => 'Agak sulit', 2 => 'Sangat sulit', 3 => 'Sangat sulit sekali'];

        ScreeningResponse::create([
            'user_id' => $userId,
            'score' => $depScore + $anxScore + $impScore,
            'category' => "Depresi: {$depRes['cat']} | Kecemasan: {$anxRes['cat']} | Dampak: {$impRes['cat']}",
            'answers_detail' => [
                'depression' => [
                    'score' => $depScore,
                    'category' => $depRes['cat'],
                    'recommendation' => $depRes['rec'],
                    'high_risk_trigger' => false,
                    'detail' => $depDetails
                ],
                'anxiety' => [
                    'score' => $anxScore,
                    'category' => $anxRes['cat'],
                    'recommendation' => $anxRes['rec'],
                    'detail' => $anxDetails
                ],
                'impact' => [
                    'score' => $impScore,
                    'category' => $impRes['cat'],
                    'text_answer' => $impactOptions[$impScore] ?? 'Tidak sulit sama sekali'
                ]
            ],
            'created_at' => now()->subDay(),
            'updated_at' => now()->subDay(),
        ]);
    }
}
