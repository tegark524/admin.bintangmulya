@extends('layouts.app')

@section('title', 'Daftar Siswa')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Siswa</h6>
                <div>
                    <a href="{{ route('students.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Tambah Siswa
                    </a>
                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#importModal">
                        <i class="fas fa-file-import"></i> Import
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Search and Filter -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('students.index') }}">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Cari nama/no HP..."
                                    value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-end">
                            <div class="dropdown mr-2">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                    data-toggle="dropdown">
                                    Filter Paket
                                </button>
                                <div class="dropdown-menu">
                                    @foreach (['Semua', 'Paket 3x', 'Paket 5x', 'Paket 7x', 'Paket 10x', 'Tambahan'] as $pkg)
                                        <a class="dropdown-item"
                                            href="{{ route('students.index', ['package' => $pkg == 'Semua' ? null : $pkg]) }}">
                                            {{ $pkg }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            <a href="{{ route('students.index') }}" class="btn btn-outline-danger">
                                <i class="fas fa-sync-alt"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Student Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th width="5%">#</th>
                                <th>Nama Siswa</th>
                                <th>No. HP</th>
                                <th width="8%">Gender</th>
                                <th>Pendidikan</th>
                                <th>Paket</th>
                                <th width="12%">Mulai Belajar</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($students as $student)
                                <tr>
                                    <td>{{ $loop->iteration + ($students->currentPage() - 1) * $students->perPage() }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-40 symbol-light-primary mr-3">
                                                <span class="symbol-label">
                                                    @if ($student->gender == 'L')
                                                        <i class="fas fa-male text-primary"></i>
                                                    @else
                                                        <i class="fas fa-female text-danger"></i>
                                                    @endif
                                                </span>
                                            </div>
                                            <div>
                                                <div class="font-weight-bold">{{ $student->name }}</div>
                                                <div class="text-muted small">{{ $student->address }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $student->phone }}</td>
                                    <td class="text-center">
                                        @if ($student->gender == 'L')
                                            <span class="badge badge-primary">L</span>
                                        @else
                                            <span class="badge badge-pink">P</span>
                                        @endif
                                    </td>
                                    <td>{{ $student->last_education }}</td>
                                    <td>
                                        <span
                                            class="badge
                                    @if (str_contains($student->package, 'Paket')) badge-success
                                    @else badge-warning @endif">
                                            {{ $student->package }}
                                        </span>
                                    </td>
                                    <td>{{ $student->start_date->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('students.edit', $student->id) }}"
                                                class="btn btn-sm btn-icon btn-primary mr-2" data-toggle="tooltip"
                                                title="Edit">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <form action="{{ route('students.destroy', $student->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-icon btn-danger"
                                                    onclick="return confirm('Hapus data ini?')" data-toggle="tooltip"
                                                    title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            <a href="{{ route('students.show', $student->id) }}"
                                                class="btn btn-sm btn-icon btn-info ml-2" data-toggle="tooltip"
                                                title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="fas fa-user-slash fa-2x text-muted mb-3"></i>
                                        <h5 class="text-muted">Tidak ada data siswa</h5>
                                        <a href="{{ route('students.create') }}" class="btn btn-sm btn-primary mt-2">
                                            <i class="fas fa-plus"></i> Tambah Siswa Pertama
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($students->hasPages())
                    <div class="row mt-4">
                        <div class="col-md-12 d-flex justify-content-center">
                            {{ $students->withQueryString()->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Data Siswa</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Pilih File Excel</label>
                            <input type="file" name="file" class="form-control-file" required>
                            <small class="form-text text-muted">
                                Format file: .xlsx, .csv.
                                <a href="{{ asset('templates/student_template.xlsx') }}">Download template</a>
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Inisialisasi tooltip
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });

        // Auto close alert
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 3000);
    </script>
@endpush

@push('styles')
    <style>
        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.03);
        }

        .badge-pink {
            background-color: #e83e8c;
            color: white;
        }

        .symbol {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .symbol-label {
            font-size: 1.2rem;
        }
    </style>
@endpush
