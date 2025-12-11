@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- 1. Tambahkan pembungkus <div class="card"> --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tambah Paket Kursus Baru</h3>
            </div>

            {{-- 2. Tag <form> harus dimulai di sini, membungkus semua input dan tombol --}}
            <form action="{{ route('packages.store') }}" method="POST">

                {{-- 3. @csrf harus berada di dalam <form> --}}
                @csrf

                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Paket <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="price" id="price"
                            class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="total_meetings" class="form-label">Jumlah Pertemuan <span
                                class="text-danger">*</span></label>
                        <input type="number" name="total_meetings" id="total_meetings"
                            class="form-control @error('total_meetings') is-invalid @enderror"
                            value="{{ old('total_meetings') }}" required>
                        @error('total_meetings')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('packages.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Paket</button>
                </div>
            </form>
            {{-- Tag </form> berakhir di sini, setelah card-footer --}}
        </div>
    </div>
@endsection
