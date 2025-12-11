{{-- Perbaikan untuk: resources/views/instructors/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Daftar Instruktur</h3>
                    <a href="{{ route('instructors.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Instruktur
                    </a>
                </div>
            </div>
            <div class="card-body">
                {{-- Menampilkan notifikasi sukses --}}
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                {{-- 1. Tambah kolom # untuk nomor --}}
                                <th>#</th>
                                <th>Nama</th>
                                <th>No. HP</th>
                                <th>Bergabung</th>
                                <th>Lama Bekerja</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($instructors as $instructor)
                                <tr>
                                    {{-- 2. Kolom untuk nomor iterasi --}}
                                    <td>{{ $instructors->firstItem() + $loop->index }}</td>
                                    <td>{{ $instructor->name }}</td>
                                    <td>{{ $instructor->phone ?? '-' }}</td>
                                    {{-- 3. Tambahkan casting 'date' di model Instructor agar bisa format --}}
                                    <td>{{ \Carbon\Carbon::parse($instructor->join_date)->format('d F Y') }}</td>
                                    <td>{{ $instructor->duration }}</td>
                                    {{-- Ganti bagian <td> untuk Aksi di instructors/index.blade.php --}}
                                    <td>
                                        <a href="{{ route('instructors.edit', $instructor->id) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('instructors.destroy', $instructor->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Anda yakin ingin menghapus instruktur ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada data instruktur</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer clearfix">
                {{ $instructors->links() }}
            </div>
        </div>
    </div>
@endsection
