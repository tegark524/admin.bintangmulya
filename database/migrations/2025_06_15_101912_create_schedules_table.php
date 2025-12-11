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
        // database/migrations/xxxx_xx_xx_xxxxxx_create_driving_packages_table.php
Schema::create('driving_packages', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->integer('price');
    $table->integer('total_meetings'); // <-- TAMBAHKAN KOLOM INI
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
