{{-- resources/views/packages/edit.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Paket Kursus</h3>
            </div>
            <form action="{{ route('packages.update', $package->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- PENTING: Method untuk update --}}
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Paket</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $package->name) }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Harga (Rp)</label>
                        <input type="number" name="price" class="form-control"
                            value="{{ old('price', $package->price) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="total_meetings" class="form-label">Jumlah Pertemuan</label>
                        <input type="number" name="total_meetings" class="form-control"
                            value="{{ old('total_meetings', $package->total_meetings) }}" required>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('packages.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Paket</button>
                </div>
            </form>
        </div>
    </div>
@endsection
