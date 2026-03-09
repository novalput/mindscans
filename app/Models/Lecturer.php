<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Lecturer extends Model
{
    protected $table = 'lecturer';
    protected $fillable = [
        'user_id',
        'gender',
        'kampus',
        'program_studi',
        'jabatan_fungsional',
        'pendidikan_terakhir',
        'status_ikatan_kerja',
        'status_aktivitas'
    ];

    /* ================= RELATIONS ================= */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
