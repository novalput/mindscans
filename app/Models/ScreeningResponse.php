<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScreeningResponse extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'score',
        'category',
        'lecturer_advice',
        'answers_detail',
        'gingivitis_image',
        'detection_result',
    ];

    // Array jawaban disimpan sebagai JSON di database,
    // tapi diakses sebagai Array di Laravel
    protected $casts = [
        'answers_detail' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
