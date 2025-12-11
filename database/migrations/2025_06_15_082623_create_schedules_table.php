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
        // database/migrations/xxxx_xx_xx_xxxxxx_create_schedules_table.php
Schema::create('schedules', function (Blueprint $table) {
    $table->id();
    $table->foreignId('student_id')->constrained()->onDelete('cascade');
    $table->foreignId('instructor_id')->constrained()->onDelete('cascade');
    $table->date('schedule_date');
    $table->integer('schedule_time'); // Jam dalam format 24 jam (e.g., 9, 14)
    $table->enum('status', ['scheduled', 'completed', 'absent'])->default('scheduled');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
