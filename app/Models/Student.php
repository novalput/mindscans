<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'nim',
        'kampus',
        'jenjang',
        'program_studi',
        'gender',
        'status'
    ];

    /* ================= RELATIONS ================= */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function screenings()
    {
        // Hubungkan berdasarkan user_id, karena screening_responses pakai user_id
        return $this->hasMany(ScreeningResponse::class, 'user_id', 'user_id');
    }
}
