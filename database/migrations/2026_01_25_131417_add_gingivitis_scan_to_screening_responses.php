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
        Schema::table('screening_responses', function (Blueprint $table) {
            $table->string('gingivitis_image')->nullable();
            $table->json('detection_result')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('screening_responses', function (Blueprint $table) {
            $table->dropColumn(['gingivitis_image', 'detection_result']);
        });
    }
};
