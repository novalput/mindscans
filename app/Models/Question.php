<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',          // Tipe: knowledge, attitude, skill, gingivitis_check
        'subtype',       // Sub tipe kuesioner
        'question_text', // Teks pertanyaan
        'order',         // Urutan tampilan
    ];

    public static function getScoringMetrics()
    {
        $totalQuestions = self::count();
        $maxScore = $totalQuestions * 3;
        $moderateThreshold = floor($maxScore / 3);
        $warningThreshold = floor(2 * $maxScore / 3) + 1;

        return (object) [
            'total_questions' => $totalQuestions,
            'max_score' => $maxScore,
            'moderate_threshold' => $moderateThreshold,
            'warning_threshold' => $warningThreshold,
        ];
    }
}
