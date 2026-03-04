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
        Schema::create('screening_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Tipe: 'knowledge_pre', 'knowledge_post', 'attitude', 'gingivitis_check', 'skill_check'
            $table->string('type');

            $table->integer('score')->nullable(); // Total skor
            $table->string('category'); // Hasil: 'Baik', 'Cukup', 'Kurang' atau 'Berisiko'

            // Menyimpan jawaban mentah dalam JSON untuk keperluan audit/detail
            $table->json('answers_detail')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screening_responses');
    }
};
