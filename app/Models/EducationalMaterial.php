<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalMaterial extends Model
{
    use HasFactory;

    /**
     * Field yang boleh diisi secara massal (Mass Assignment).
     */
    protected $fillable = [
        'title',       // Judul Materi
        'slug',       // Slug untuk URL
        'category',    // Kategori (Dasar, Penyakit, Nutrisi, dll)
        'content',     // Isi teks materi
        'thumbnail',   // Path gambar thumbnail
        'video_url',   // Link video youtube (jika ada)
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
