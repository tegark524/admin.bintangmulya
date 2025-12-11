<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Carbon\Carbon; // Penting untuk mengelola tanggal

class ScheduleController extends Controller
{
    /**
     * Menampilkan daftar semua jadwal yang ada (opsional, baik untuk admin).
     */
    public function index()
    {
        $schedules = Schedule::with(['student', 'instructor'])
                            ->orderBy('schedule_date', 'desc')
                            ->paginate(15);
        return view('schedules.index', compact('schedules'));
    }

    /**
     * Menampilkan halaman utama untuk absensi harian.
     * PASTIKAN FUNGSI INI ADA DAN NAMA-NYA BENAR.
     */
    public function attendancePage(Request $request)
    {
        // Ambil tanggal dari filter, jika tidak ada, gunakan tanggal hari ini
        $filterDate = $request->input('date', Carbon::today()->toDateString());

        $schedules = Schedule::whereDate('schedule_date', $filterDate)
            ->with(['student', 'instructor']) // Eager loading untuk performa
            ->orderBy('schedule_time')
            ->get();

        return view('attendance.page', compact('schedules', 'filterDate'));
    }

    /**
     * Memproses aksi absensi (menandai Hadir atau Tidak Hadir).
     */
    public function markAttendance(Request $request, Schedule $schedule)
    {
        $request->validate(['status' => 'required|in:completed,absent']);

        $schedule->update(['status' => $request->status]);

        if ($request->status == 'completed') {
            return back()->with('success', 'Kehadiran berhasil dicatat!');
        }

        // Jika tidak hadir, langsung arahkan ke halaman edit untuk reschedule
        return redirect()->route('schedules.edit', $schedule->id)
                       ->with('warning', 'Siswa ditandai tidak hadir. Silakan atur jadwal ulang.');
    }

    /**
     * Menampilkan form untuk menjadwal ulang (reschedule).
     */
    public function edit(Schedule $schedule)
    {
        // Ambil daftar instruktur untuk dropdown
        $instructors = Instructor::all();
        return view('schedules.edit', compact('schedule', 'instructors'));
    }

    /**
     * Menyimpan data jadwal yang sudah dijadwal ulang.
     */
    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
        'schedule_date' => 'required|date|after_or_equal:today',
        'schedule_time' => 'required|integer|min:7|max:20',
        'instructor_id' => 'required|exists:instructors,id',
        'car_type' => 'required|in:manual,matic', // <-- TAMBAHKAN VALIDASI INI
    ]);

    $schedule->update([
        'schedule_date' => $request->schedule_date,
        'schedule_time' => $request->schedule_time,
        'instructor_id' => $request->instructor_id,
        'car_type' => $request->car_type, // <-- TAMBAHKAN DATA INI
        'status' => 'scheduled',
    ]);

        // Arahkan kembali ke halaman absensi pada tanggal baru
        return redirect()->route('attendance.page', ['date' => $schedule->schedule_date])
                       ->with('success', 'Jadwal berhasil diperbarui!');
    }

    /**
     * Hapus jadwal jika diperlukan.
     */
    public function destroy(Schedule $schedule)
    {
        try {
            $schedule->delete();
            return back()->with('success', 'Jadwal berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus jadwal: ' . $e->getMessage());
        }
    }

    public function updateCarType(Request $request, Schedule $schedule)
    {
        // 1. Validasi input yang masuk
        $validated = $request->validate([
            'car_type' => 'required|in:manual,matic'
        ]);

        // 2. Update data di database
        $schedule->update($validated);

        // 3. Kirim respon JSON sebagai konfirmasi
        return response()->json([
            'success' => true,
            'message' => 'Tipe mobil berhasil diperbarui!'
        ]);
    }
}
