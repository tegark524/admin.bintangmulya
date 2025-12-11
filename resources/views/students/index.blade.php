@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title">Data Siswa</h3>
                <a href="{{ route('students.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Siswa
                </a>
            </div>
            <div class="card-body">

                {{-- =============================================== --}}
                {{-- == BAGIAN FORM FILTER & URUTKAN (BARU) == --}}
                {{-- =============================================== --}}
                <form action="{{ route('students.index') }}" method="GET" class="mb-4">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label for="package" class="form-label">Filter Paket</label>
                            <select name="package" id="package" class="custom-select">
                                <option value="">Semua Paket</option>
                                @foreach ($packages as $package)
                                    <option value="{{ $package }}"
                                        {{ request('package') == $package ? 'selected' : '' }}>
                                        {{ $package }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="registration_date" class="form-label">Tgl. Pendaftaran</label>
                            <input type="date" name="registration_date" id="registration_date" class="form-control"
                                value="{{ request('registration_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="sort_by" class="form-label">Urutkan Berdasarkan</label>
                            <select name="sort_by" id="sort_by" class="custom-select">
                                <option value="newest" {{ request('sort_by', 'newest') == 'newest' ? 'selected' : '' }}>
                                    Pendaftar Terbaru</option>
                                <option value="oldest" {{ request('sort_by') == 'oldest' ? 'selected' : '' }}>Pendaftar
                                    Terlama</option>
                                <option value="name_az" {{ request('sort_by') == 'name_az' ? 'selected' : '' }}>Nama (A-Z)
                                </option>
                                <option value="name_za" {{ request('sort_by') == 'name_za' ? 'selected' : '' }}>Nama (Z-A)
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-info"><i class="fas fa-filter"></i> Filter</button>
                            <a href="{{ route('students.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </form>
                {{-- =============================================== --}}

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th>Paket</th>
                                <th>Sisa Pertemuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                                <tr>
                                    <td>{{ $students->firstItem() + $loop->index }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->phone }}</td>
                                    <td><span class="badge bg-primary">{{ $student->package }}</span></td>
                                    <td>{{ $student->remaining_lessons }} Hari</td>
                                    <td>
                                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-warning"
                                            title="Edit Data Diri">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('students.destroy', $student->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Yakin ingin hapus siswa ini? Semua jadwalnya juga akan terhapus.');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" title="Hapus Siswa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        @if (request()->hasAny(['package', 'registration_date']))
                                            Tidak ada data siswa yang cocok dengan filter Anda.
                                        @else
                                            Belum ada data siswa.
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer clearfix">
                {{-- PENTING: Tambahkan withQueryString() agar filter tetap aktif saat pindah halaman --}}
                {{ $students->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
