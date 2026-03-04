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
        Schema::create('brushing_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Relasi ke Student
            $table->date('log_date');
            $table->boolean('morning')->default(false); // Sikat gigi pagi
            $table->boolean('night')->default(false);   // Sikat gigi malam
            $table->timestamps();

            // Memastikan satu user hanya punya satu log per hari
            $table->unique(['user_id', 'log_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brushing_logs');
    }
};
