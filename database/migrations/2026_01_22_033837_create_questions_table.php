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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            // Tipe: 'knowledge' (Pengetahuan), 'attitude' (Sikap), 'gingivitis' (Deteksi), 'skill' (Keterampilan)
            $table->string('type');
            $table->text('question_text');
            $table->integer('order')->default(0); // Urutan soal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
