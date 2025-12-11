@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Jadwal Ulang (Reschedule)
                </h3>
            </div>
            <form action="{{ route('schedules.update', $schedule->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- PENTING: Method untuk update --}}
                <div class="card-body">
                    {{-- Menampilkan notifikasi dari controller --}}
                    @if (session('warning'))
                        <div class="alert alert-warning">{{ session('warning') }}</div>
                    @endif

                    <div class="alert alert-info">
                        <h5 class="alert-heading">Informasi Jadwal Awal</h5>
                        <p>
                            Siswa: <strong>{{ $schedule->student->name }}</strong><br>
                            Jadwal Awal:
                            <strong>{{ \Carbon\Carbon::parse($schedule->schedule_date)->isoFormat('dddd, D MMMM Y') }}</strong>,
                            Jam <strong>{{ $schedule->schedule_time }}:00</strong>
                        </p>
                    </div>

                    <h5 class="mt-4">Atur Tanggal dan Waktu Baru</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="schedule_date" class="form-label">Tanggal Baru <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="schedule_date" id="schedule_date"
                                class="form-control @error('schedule_date') is-invalid @enderror"
                                value="{{ old('schedule_date', $schedule->schedule_date) }}" required>
                            @error('schedule_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="schedule_time" class="form-label">Jam Baru (07-20) <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="schedule_time" id="schedule_time"
                                class="form-control @error('schedule_time') is-invalid @enderror" min="7"
                                max="20" value="{{ old('schedule_time', $schedule->schedule_time) }}" required>
                            @error('schedule_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="car_type" class="form-label">Tipe Mobil</button>
                                <select name="car_type" id="car_type" class="form-select" required>
                                    <option value="manual"
                                        {{ old('car_type', $schedule->car_type) == 'manual' ? 'selected' : '' }}>Manual
                                    </option>
                                    <option value="matic"
                                        {{ old('car_type', $schedule->car_type) == 'matic' ? 'selected' : '' }}>Matic
                                    </option>
                                </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="instructor_id" class="form-label">Instruktur Baru <span
                                    class="text-danger">*</span></label>
                            <select name="instructor_id" id="instructor_id"
                                class="form-select @error('instructor_id') is-invalid @enderror" required>
                                @foreach ($instructors as $instructor)
                                    <option value="{{ $instructor->id }}"
                                        {{ old('instructor_id', $schedule->instructor_id) == $instructor->id ? 'selected' : '' }}>
                                        {{ $instructor->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('instructor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    {{-- Tombol batal akan kembali ke halaman absensi pada tanggal jadwal yang LAMA --}}
                    <a href="{{ route('attendance.page', ['date' => $schedule->schedule_date]) }}"
                        class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Jadwal</button>
                </div>
            </form>
        </div>
    </div>
@endsection
