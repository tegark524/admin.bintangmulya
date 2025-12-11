@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            {{-- BAGIAN HEADER DIPERBAIKI --}}
            <div class="card-header">
                <h3 class="card-title">Absensi Harian</h3>

                <div class="card-tools">
                    {{-- Form diletakkan di dalam div card-tools --}}
                    <form method="GET" action="{{ route('attendance.page') }}" class="d-inline-flex align-items-center">

                        {{-- Menggunakan mr-2 (margin-right) untuk Bootstrap 4 --}}
                        <input type="date" name="date" class="form-control form-control-sm mr-2"
                            value="{{ $filterDate }}">

                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-filter"></i> Filter
                        </button>

                    </form>
                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('warning'))
                    <div class="alert alert-warning">{{ session('warning') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th style="width: 10%;">Jam</th>
                                <th>Siswa</th>
                                <th>Instruktur</th>
                                <th style="width: 15%;">Tipe Mobil</th>
                                <th style="width: 15%;">Status</th>
                                <th style="width: 20%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($schedules as $schedule)
                                <tr>
                                    <td>{{ str_pad($schedule->schedule_time, 2, '0', STR_PAD_LEFT) }}:00</td>
                                    <td>{{ $schedule->student->name }}</td>
                                    <td>{{ $schedule->instructor->name }}</td>

                                    {{-- BAGIAN ISI TABEL DIPERBAIKI URUTANNYA --}}
                                    <td>
                                        {{-- Kolom Tipe Mobil --}}
                                        <select class="custom-select custom-select-sm car-type-select"
                                            data-id="{{ $schedule->id }}">
                                            <option value="manual" {{ $schedule->car_type == 'manual' ? 'selected' : '' }}>
                                                Manual</option>
                                            <option value="matic" {{ $schedule->car_type == 'matic' ? 'selected' : '' }}>
                                                Matic
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        {{-- Kolom Status --}}
                                        @if ($schedule->status == 'completed')
                                            <span class="badge bg-success">Hadir</span>
                                        @elseif($schedule->status == 'absent')
                                            <span class="badge bg-danger">Tidak Hadir</span>
                                        @else
                                            <span class="badge bg-warning">Terjadwal</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{-- Kolom Aksi --}}
                                        @if ($schedule->status == 'scheduled')
                                            <form action="{{ route('attendance.mark', $schedule->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="btn btn-sm btn-success">Hadir</button>
                                            </form>
                                            <form action="{{ route('attendance.mark', $schedule->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <input type="hidden" name="status" value="absent">
                                                <button type="submit" class="btn btn-sm btn-danger">Tidak Hadir</button>
                                            </form>
                                        @else
                                            <a href="{{ route('schedules.edit', $schedule->id) }}"
                                                class="btn btn-sm btn-secondary">Reschedule</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    {{-- Colspan diubah menjadi 6 --}}
                                    <td colspan="6" class="text-center">Tidak ada jadwal untuk tanggal ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Kode JavaScript untuk AJAX update tipe mobil (tidak diubah) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            document.querySelectorAll('.car-type-select').forEach(selectElement => {
                selectElement.addEventListener('change', function(event) {
                    const scheduleId = this.dataset.id;
                    const newCarType = this.value;
                    this.style.backgroundColor = '#ffecb3';
                    fetch(`/schedules/${scheduleId}/update-car-type`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                car_type: newCarType
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Gagal menghubungi server.');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                this.style.backgroundColor = '#c8e6c9';
                                setTimeout(() => {
                                    this.style.backgroundColor = '';
                                }, 1500);
                            } else {
                                this.style.backgroundColor = '#ffcdd2';
                                alert('Gagal memperbarui tipe mobil.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            this.style.backgroundColor = '#ffcdd2';
                            alert('Terjadi kesalahan. Lihat console untuk detail.');
                        });
                });
            });
        });
    </script>
@endpush
