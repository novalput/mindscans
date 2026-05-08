<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biodata extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jenis_kelamin',
        'ttl',
        'alamat_asal',
        'nama_kampus',
        'prodi',
        'status',
        'job_description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
