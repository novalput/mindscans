<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'nik',
        'dob',
        'gender',
        'address',
        'education',
        'trimester',
        'pregnancy_week',
        'last_period_date'
    ];

    protected $casts = [
        'dob' => 'date',
        'last_period_date' => 'date',
    ];

    /* ================= RELATIONS ================= */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function brushingLogs()
    {
        return $this->hasMany(BrushingLog::class);
    }

    public function healthVisits()
    {
        return $this->hasMany(HealthVisit::class);
    }

    public function screenings()
    {
        return $this->hasMany(ScreeningResponse::class);
    }
}
