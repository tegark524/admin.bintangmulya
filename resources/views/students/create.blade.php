@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tambah Siswa Baru</h3>
            </div>
            {{-- Form tag sekarang membungkus card-body dan card-footer --}}
            <form action="{{ route('students.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <h5>Data Diri Siswa</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Telepon <span class="text-danger">*</span></label>
                            <input type="text" name="phone" id="phone"
                                class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}"
                                required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="address" class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" rows="2"
                                required>{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label">Jenis Kelamin <span
                                    class="text-danger">*</span></label>
                            {{-- Menggunakan custom-select untuk AdminLTE/Bootstrap 4 --}}
                            <select name="gender" id="gender"
                                class="custom-select @error('gender') is-invalid @enderror" required>
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="last_education" class="form-label">Pendidikan Terakhir <span
                                    class="text-danger">*</span></label>
                            <select name="last_education" id="last_education"
                                class="custom-select @error('last_education') is-invalid @enderror" required>
                                <option value="">-- Pilih Pendidikan --</option>
                                @foreach ($educations as $edu)
                                    <option value="{{ $edu }}"
                                        {{ old('last_education') == $edu ? 'selected' : '' }}>{{ $edu }}</option>
                                @endforeach
                            </select>
                            @error('last_education')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>

                    <h5>Paket & Penjadwalan</h5>
                    <div class="mb-3">
                        <label for="package_id" class="form-label">Pilih Paket <span class="text-danger">*</span></label>
                        <select name="package_id" id="package_id"
                            class="custom-select @error('package_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Paket --</option>
                            @foreach ($packages as $package)
                                <option value="{{ $package->id }}" data-meetings="{{ $package->total_meetings }}"
                                    {{ old('package_id') == $package->id ? 'selected' : '' }}>
                                    {{ $package->name }} ({{ $package->total_meetings }} Pertemuan)
                                </option>
                            @endforeach
                        </select>
                        @error('package_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="schedule-container">
                        {{-- Konten jadwal akan muncul di sini via JavaScript --}}
                    </div>
                </div>

                <div class="card-footer text-end">
                    <a href="{{ route('students.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Pendaftaran</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const packageSelect = document.getElementById('package_id');

            function generateScheduleInputs() {
                const container = document.getElementById('schedule-container');
                const selectedOption = packageSelect.options[packageSelect.selectedIndex];
                const meetings = selectedOption.getAttribute('data-meetings');

                container.innerHTML = '';

                if (!meetings || meetings <= 0) return;

                let scheduleHtml = '<h6 class="mt-4">Silakan Atur Jadwal Pertemuan:</h6>';

                for (let i = 0; i < meetings; i++) {
                    scheduleHtml += `
                    <div class="row align-items-center mb-3 p-2 border rounded bg-light">
                        <strong class="mb-2 col-12">Pertemuan ke-${i + 1}</strong>

                        {{-- KODE DI BAWAH INI DIPERBAIKI (3+3+3+3 = 12) --}}
                        <div class="col-md-3 mb-2">
                            <label class="form-label small">Tanggal</label>
                            <input type="date" name="schedules[${i}][date]" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label small">Jam (07-20)</label>
                            <input type="number" name="schedules[${i}][time]" class="form-control form-control-sm" min="7" max="20" placeholder="Contoh: 14" required>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label small">Tipe Mobil</label>
                            <select name="schedules[${i}][car_type]" class="custom-select custom-select-sm" required>
                                <option value="manual">Manual</option>
                                <option value="matic">Matic</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label small">Instruktur</label>
                            <select name="schedules[${i}][instructor_id]" class="custom-select custom-select-sm" required>
                                @foreach ($instructors as $instructor)
                                    <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                `;
                }
                container.innerHTML = scheduleHtml;
            }

            packageSelect.addEventListener('change', generateScheduleInputs);

            if (packageSelect.value) {
                generateScheduleInputs();
            }
        });
    </script>
@endpush
