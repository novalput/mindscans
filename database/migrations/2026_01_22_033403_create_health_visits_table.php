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
        Schema::create('health_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Pasien
            $table->foreignId('lecturer_id')->nullable()->constrained('users'); // Lecturer yang memeriksa (jika ada)
            $table->date('visit_date');
            $table->text('consultation_notes')->nullable(); // Catatan Konsultasi
            $table->text('treatment_notes')->nullable();    // Tindakan Perawatan (Scaling, dll)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_visits');
    }
};
