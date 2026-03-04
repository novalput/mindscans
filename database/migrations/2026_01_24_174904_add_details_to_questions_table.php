<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            // Menyimpan pilihan ganda atau skala likert dalam format JSON
            // Contoh: {"A": "Jawaban A", "B": "Jawaban B"}
            $table->json('options')->nullable();
            // Kunci jawaban untuk pengetahuan (misal: 'A')
            $table->string('correct_answer')->nullable();

            // Kategori soal: 'knowledge' (Pengetahuan) atau 'attitude' (Sikap)
            // Kolom 'type' sudah ada di migration sebelumnya, jadi tidak perlu ditambah
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn(['options', 'correct_answer']);
        });
    }
};
