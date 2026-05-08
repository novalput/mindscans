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
        Schema::create('biodatas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->enum('jenis_kelamin', ['male', 'female']);
            $table->date('ttl')->nullable();
            $table->text('alamat_asal')->nullable();
            $table->string('nama_kampus')->nullable();
            $table->string('prodi')->nullable();
            $table->string('status')->nullable();
            $table->string('job_description')->nullable();

            $table->timestamps();
            
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biodatas');
    }
};
