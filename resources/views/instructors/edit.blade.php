{{-- resources/views/instructors/edit.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Data Instruktur</h3>
            </div>
            <form action="{{ route('instructors.update', $instructor->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name', $instructor->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Nomor Telepon</label>
                        <input type="text" name="phone" class="form-control"
                            value="{{ old('phone', $instructor->phone) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="join_date" class="form-label">Tanggal Bergabung</label>
                        <input type="date" name="join_date" class="form-control"
                            value="{{ old('join_date', $instructor->join_date) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="experience" class="form-label">Pengalaman</label>
                        <textarea name="experience" class="form-control" rows="3">{{ old('experience', $instructor->experience) }}</textarea>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('instructors.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Instruktur</button>
                </div>
            </form>
        </div>
    </div>
@endsection
