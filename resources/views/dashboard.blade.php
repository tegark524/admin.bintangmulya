@extends('layouts.app')

@section('content')
    {{-- Header Halaman --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                    <p>{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Kartu Statistik --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $schedulesTodayCount }}</h3>
                    <p>Jadwal Hari Ini</p>
                </div>
                <div class="icon"><i class="fas fa-calendar-day"></i></div>
                <a href="{{ route('attendance.page') }}" class="small-box-footer">Lihat Detail <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalActiveSchedules }}</h3>
                    <p>Total Jadwal Aktif</p>
                </div>
                <div class="icon"><i class="fas fa-tasks"></i></div>
                <a href="{{ route('attendance.page') }}" class="small-box-footer">Lihat Detail <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalStudents }}</h3>
                    <p>Total Siswa</p>
                </div>
                <div class="icon"><i class="fas fa-user-graduate"></i></div>
                <a href="{{ route('students.index') }}" class="small-box-footer">Lihat Detail <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $totalInstructors }}</h3>
                    <p>Total Instruktur</p>
                </div>
                <div class="icon"><i class="fas fa-user-tie"></i></div>
                <a href="{{ route('instructors.index') }}" class="small-box-footer">Lihat Detail <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    {{-- Diagram Batang Mingguan --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-chart-bar mr-1"></i>
                Jadwal Seminggu Ke Depan (Mulai {{ $startDate->isoFormat('D MMM') }})
            </h3>
            <div class="card-tools">
                <a href="{{ route('dashboard', ['start_date' => $prevWeekDate]) }}"
                    class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-chevron-left"></i> Minggu Lalu
                </a>
                <a href="{{ route('dashboard', ['start_date' => $nextWeekDate]) }}"
                    class="btn btn-sm btn-outline-secondary">
                    Minggu Depan <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <canvas id="weeklyScheduleChart" height="100"></canvas>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('weeklyScheduleChart').getContext('2d');

            // Ambil data dari PHP dan ubah ke format JSON yang aman
            const chartLabels = @json($chartLabels);
            const chartData = @json($chartData);

            const weeklyScheduleChart = new Chart(ctx, {
                type: 'bar', // Tipe diagram adalah batang
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Jumlah Jadwal',
                        data: chartData,
                        backgroundColor: 'rgba(0, 123, 255, 0.7)',
                        borderColor: 'rgba(0, 123, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                // Hanya tampilkan angka bulat di sumbu Y
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false // Sembunyikan legenda
                        }
                    }
                }
            });
        });
    </script>
@endpush
