@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title">Daftar Paket Kursus</h3>
                <a href="{{ route('packages.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Paket
                </a>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Nama Paket</th>
                                <th>Harga</th>
                                <th>Jumlah Pertemuan</th>
                                <th style="width: 120px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($packages as $package)
                                <tr>
                                    <td>{{ $packages->firstItem() + $loop->index }}</td>
                                    <td>{{ $package->name }}</td>
                                    <td>Rp {{ number_format($package->price, 0, ',', '.') }}</td>
                                    <td>{{ $package->total_meetings }} kali</td>
                                    {{-- Ganti bagian <td> untuk Aksi --}}
                                    <td>
                                        <a href="{{ route('packages.edit', $package->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('packages.destroy', $package->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Yakin ingin hapus paket ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data paket kursus.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer clearfix">
                {{-- Tampilkan link paginasi --}}
                {{ $packages->links() }}
            </div>
        </div>
    </div>
@endsection
