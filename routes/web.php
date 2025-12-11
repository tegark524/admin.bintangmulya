<?php

use App\Http\Controllers\{
    DashboardController,
    ProfileController,
    StudentController,
    InstructorController,
    ScheduleController,
    DrivingPackageController,
    UserController
};

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendaftarkan rute web untuk aplikasi Anda. Rute-rute
| ini dimuat oleh RouteServiceProvider dan semuanya akan
| ditetapkan ke grup middleware "web".
|
*/

// Rute root akan langsung mengalihkan ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Rute untuk autentikasi (login, register, dll) yang dibuat oleh Breeze/UI
require __DIR__.'/auth.php';

// Semua rute di bawah ini hanya bisa diakses oleh pengguna yang sudah login
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute Profil Pengguna (bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Manajemen Siswa (Students)
    Route::resource('students', StudentController::class)->except(['show']);

    // Semua user yang login dianggap admin dan bisa mengelola user lain
    Route::resource('users', UserController::class);

    // Manajemen Instruktur (Instructors)
    Route::resource('instructors', InstructorController::class);

    Route::resource('packages', DrivingPackageController::class);


    Route::get('/attendance', [ScheduleController::class, 'attendancePage'])->name('attendance.page');
    Route::post('/attendance/{schedule}/mark', [ScheduleController::class, 'markAttendance'])->name('attendance.mark');
// Tambahkan juga route untuk reschedule jika diperlukan
    Route::put('/attendance/{schedule}/reschedule', [ScheduleController::class, 'reschedule'])->name('attendance.reschedule');
    // Manajemen Jadwal (Schedules)


    Route::resource('schedules', ScheduleController::class);
    Route::prefix('schedules')->name('schedules.')->group(function () {
    Route::get('/calendar', [ScheduleController::class, 'calendar'])->name('calendar');
    Route::post('/{schedule}/attendance', [ScheduleController::class, 'updateAttendance'])->name('attendance');
    });

    Route::resource('packages', DrivingPackageController::class)->only(['index']);

    Route::patch('/schedules/{schedule}/update-car-type', [ScheduleController::class, 'updateCarType'])->name('schedules.updateCarType');

});
