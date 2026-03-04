<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrushingLog extends Model
{
    protected $fillable = ['user_id', 'log_date', 'morning', 'night'];

    // Casting agar otomatis jadi tipe data yang sesuai (bukan string)
    protected $casts = [
        'log_date' => 'date',
        'morning' => 'boolean',
        'night' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
