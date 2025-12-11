<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_update_students_table.php
public function up()
{
    Schema::table('students', function (Blueprint $table) {
        // Hanya tambahkan kolom baru tanpa menghapus yang tidak ada
        $table->enum('gender', ['L', 'P'])->after('address');
        $table->string('last_education')->after('gender');
        $table->date('start_date')->after('package');

        // HAPUS BARIS INI JIKA ADA:
        // $table->dropColumn('photo_path');
    });
}

public function down()
{
    Schema::table('students', function (Blueprint $table) {
        $table->dropColumn(['gender', 'last_education', 'start_date']);
    });
}
};
