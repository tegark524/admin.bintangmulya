<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Hapus data existing (optional)
        DB::table('users')->truncate();

        // Insert data user default
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@drivingschool.com',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Tambahkan data lain jika diperlukan
        // DB::table('instructors')->insert([...]);
    }
}
