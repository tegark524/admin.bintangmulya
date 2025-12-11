<?php
// app/Models/Instructor.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Disarankan untuk ditambahkan
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Instructor extends Model
{
    use HasFactory; // Disarankan untuk ditambahkan

    protected $fillable = [
        'name',
        'phone',
        'join_date',
        'experience'
    ];

    /**
     * ++ TAMBAHAN: Relasi ke jadwal ++
     * Menghubungkan satu instruktur dengan banyak jadwal yang dimilikinya.
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Hitung lama bergabung, sudah dengan perbaikan.
     */
    public function getDurationAttribute()
    {
        $joinDate = Carbon::parse($this->join_date);
        $now = Carbon::now();

        // Jika tanggal bergabung ada di masa depan atau selisihnya kurang dari 1 bulan
        if ($joinDate->isFuture() || $joinDate->diffInMonths($now) < 1) {
            return 'Baru-baru ini';
        }

        // Menggunakan metode diff() untuk hasil yang lebih akurat
        $interval = $joinDate->diff($now);

        $years = $interval->y;
        $months = $interval->m;

        // Membuat output yang lebih rapi
        $parts = [];
        if ($years > 0) {
            $parts[] = "{$years} Tahun";
        }
        if ($months > 0) {
            $parts[] = "{$months} Bulan";
        }

        // Jika tidak ada tahun atau bulan (misal: tepat 1 bulan), fallback
        if (empty($parts)) {
             return '1 Bulan';
        }

        return implode(' ', $parts);
    }
}
