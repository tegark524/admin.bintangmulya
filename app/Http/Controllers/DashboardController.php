<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Instructor;
use App\Models\Schedule;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // === 1. DATA UNTUK KARTU STATISTIK ===
        $schedulesTodayCount = Schedule::whereDate('schedule_date', today())->count();
        $totalActiveSchedules = Schedule::where('status', 'scheduled')->whereDate('schedule_date', '>=', today())->count();
        $totalStudents = Student::count();
        $totalInstructors = Instructor::count();


        // === 2. DATA UNTUK DIAGRAM BATANG (CHART) ===
        // Tentukan tanggal awal (defaultnya hari ini, atau dari input navigasi)
        $startDate = $request->has('start_date') ? Carbon::parse($request->start_date) : Carbon::today();

        $dates = [];
        for ($i = 0; $i < 7; $i++) {
            $dates[] = $startDate->copy()->addDays($i);
        }

        // Ambil data jadwal untuk 7 hari ke depan dalam satu query untuk efisiensi
        $schedules = Schedule::whereBetween('schedule_date', [$dates[0], $dates[6]])
                            ->get()
                            ->groupBy(function($date) {
                                return Carbon::parse($date->schedule_date)->format('Y-m-d');
                            });

        $chartLabels = [];
        $chartData = [];

        foreach ($dates as $date) {
            $dateString = $date->format('Y-m-d');
            $chartLabels[] = $date->isoFormat('DD MMM'); // Format label (misal: 16 Jun)
            $chartData[] = $schedules->has($dateString) ? count($schedules[$dateString]) : 0; // Isi data jadwal per hari
        }

        // === 3. DATA UNTUK TOMBOL NAVIGASI ===
        $prevWeekDate = $startDate->copy()->subWeek()->toDateString();
        $nextWeekDate = $startDate->copy()->addWeek()->toDateString();


        // === 4. KIRIM SEMUA DATA KE VIEW ===
        return view('dashboard', compact(
            'schedulesTodayCount',
            'totalActiveSchedules',
            'totalStudents',
            'totalInstructors',
            'chartLabels',
            'chartData',
            'startDate',
            'prevWeekDate',
            'nextWeekDate'
        ));
    }
}
