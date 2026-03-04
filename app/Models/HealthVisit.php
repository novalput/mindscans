<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthVisit extends Model
{
    protected $fillable = [
        'user_id',
        'lecturer_id',
        'visit_date',
        'consultation_notes',
        'treatment_notes'
    ];

    protected $casts = [
        'visit_date' => 'date',
    ];

    // Relasi ke User (Pasien)
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke User (Lecturer/Pemeriksa)
    public function lecturer()
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }
}
