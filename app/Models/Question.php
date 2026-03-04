<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',          // Tipe: knowledge, attitude, skill, gingivitis_check
        'question_text', // Teks pertanyaan
        'order',         // Urutan tampilan
    ];
}
