<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
    'name',
    'phone',
    'address',
    'gender',
    'last_education',
    'package',
    'start_date'
];

protected $casts = [
    'start_date' => 'date'
];

public function schedules()
{
    return $this->hasMany(Schedule::class);
}

// Atribut dinamis untuk menghitung sisa pertemuan
public function getRemainingLessonsAttribute()
{
    // Hitung jadwal yang statusnya masih 'scheduled'
    return $this->schedules()->where('status', 'scheduled')->count();
}
}
