<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\DrivingPackage;
use App\Models\Instructor;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Menampilkan daftar semua siswa.
     */
    public function index(Request $request)
    {
        // 1. Mulai query dasar
        $query = Student::query();

        // 2. Terapkan filter jika ada input
        // Filter berdasarkan Paket
        if ($request->filled('package')) {
            $query->where('package', $request->package);
        }

        // Filter berdasarkan Tanggal Pendaftaran
        if ($request->filled('registration_date')) {
            $query->whereDate('created_at', $request->registration_date);
        }

        // 3. Terapkan urutan (sorting)
        $sortBy = $request->input('sort_by', 'newest'); // Defaultnya 'newest'

        switch ($sortBy) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name_az':
                $query->orderBy('name', 'asc');
                break;
            case 'name_za':
                $query->orderBy('name', 'desc');
                break;
            default: // 'newest'
                $query->orderBy('created_at', 'desc');
                break;
        }

        // 4. Ambil data setelah difilter dan diurutkan, lalu paginasi
        $students = $query->paginate(10);

        // 5. Ambil data semua paket untuk ditampilkan di dropdown filter
        $packages = DrivingPackage::pluck('name', 'name');

        // 6. Kirim data ke view
        return view('students.index', compact('students', 'packages'));
    }


    /**
     * Menampilkan form untuk membuat siswa baru.
     */
    public function create()
    {
        $packages = DrivingPackage::all();
        $instructors = Instructor::all();
        $educations = ['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2'];

        return view('students.create', compact('packages', 'instructors', 'educations'));
    }

    /**
     * Menyimpan siswa baru beserta jadwal-jadwalnya.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15|unique:students,phone',
            'address' => 'required|string',
            'gender' => 'required|in:L,P',
            'last_education' => 'required|string',
            'package_id' => 'required|exists:driving_packages,id',
            'schedules' => 'required|array',
            'schedules.*.date' => 'required|date|after_or_equal:today',
            'schedules.*.time' => 'required|integer|min:7|max:20',
            'schedules.*.instructor_id' => 'required|exists:instructors,id',
        ]);

        DB::beginTransaction();
        try {
            $package = DrivingPackage::findOrFail($request->package_id);
            $student = Student::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'gender' => $request->gender,
                'last_education' => $request->last_education,
                'package' => $package->name,
                'start_date' => $request->schedules[0]['date'],
                'schedules.*.car_type' => 'required|in:manual,matic',
            ]);

            foreach ($request->schedules as $scheduleData) {
                Schedule::create([
                    'student_id' => $student->id,
                    'schedule_date' => $scheduleData['date'],
                    'schedule_time' => $scheduleData['time'],
                    'instructor_id' => $scheduleData['instructor_id'],
                    'car_type' => $scheduleData['car_type'],
                    'status' => 'scheduled',
                ]);
            }
            DB::commit();
            return redirect()->route('students.index')->with('success', 'Siswa dan jadwalnya berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan form edit untuk data diri siswa.
     */
    public function edit(Student $student)
    {
        $educations = ['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2'];
        return view('students.edit', compact('student', 'educations'));
    }

    /**
     * == METHOD INI DIPERBARUI ==
     * Update HANYA data diri siswa. Jadwal tidak diubah di sini.
     */
    public function update(Request $request, Student $student)
    {
        // Validasi yang lebih lengkap untuk semua field di form edit
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15|unique:students,phone,' . $student->id,
            'address' => 'required|string',
            'gender' => 'required|in:L,P',
            'last_education' => 'required|string',
        ]);

        // Update siswa dengan data yang sudah divalidasi
        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil diperbarui!');
    }

    /**
     * Menghapus siswa (jadwal terkait akan terhapus otomatis karena onDelete('cascade')).
     */
    public function destroy(Student $student)
    {
        try {
            $student->delete();
            return back()->with('success', 'Data siswa berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Fungsi search bisa tetap digunakan.
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        return Student::where('name', 'like', "%$query%")->orWhere('phone', 'like', "%$query%")->limit(10)->get(['id', 'name', 'phone']);
    }
}
