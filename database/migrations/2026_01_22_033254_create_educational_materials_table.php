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
        Schema::create('educational_materials', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul Materi
            $table->string('category'); // e.g., 'Kesehatan Gigi', 'Nutrisi', 'Kehamilan'
            $table->text('content'); // Isi materi
            $table->string('thumbnail')->nullable();
            $table->string('video_url')->nullable(); // Link video edukasi [cite: 212]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educational_materials');
    }
};
