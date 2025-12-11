<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    // app/Models/Schedule.php
protected $fillable = [
    'student_id',
    'instructor_id',
    'schedule_date',
    'schedule_time',
    'car_type', // <-- TAMBAHKAN INI
    'status'
];

    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function instructor() {
        return $this->belongsTo(Instructor::class);
    }
}
