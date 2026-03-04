<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Lecturer extends Model
{
    protected $table = 'lecturer';
    protected $fillable = [
        'user_id',
        'nip',
        'education',
        'specialization',
        'bio'
    ];

    /* ================= RELATIONS ================= */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
