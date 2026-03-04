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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('nik', 16)->unique();
            $table->date('dob');
            $table->enum('gender', ['male', 'female']);
            $table->text('address');

            $table->enum('education', ['SD', 'SMP', 'SMA', 'Perguruan Tinggi'])->nullable();
            $table->enum('trimester', ['I', 'II', 'III'])->nullable();
            $table->unsignedTinyInteger('pregnancy_week')->nullable();
            $table->date('last_period_date')->nullable();

            $table->timestamps();

            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student');
    }
};
