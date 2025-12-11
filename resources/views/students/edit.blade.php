{{-- resources/views/students/edit.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Data Siswa: {{ $student->name }}</h3>
            </div>
            <form action="{{ route('students.update', $student->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <h5>Data Diri Siswa</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $student->name) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Telepon</label>
                            <input type="text" name="phone" class="form-control"
                                value="{{ old('phone', $student->phone) }}" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="address" class="form-control" rows="2" required>{{ old('address', $student->address) }}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="gender" class="form-select" required>
                                <option value="L" {{ old('gender', $student->gender) == 'L' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="P" {{ old('gender', $student->gender) == 'P' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pendidikan Terakhir</label>
                            <select name="last_education" class="form-select" required>
                                @foreach ($educations as $edu)
                                    <option value="{{ $edu }}"
                                        {{ old('last_education', $student->last_education) == $edu ? 'selected' : '' }}>
                                        {{ $edu }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <hr>
                    <h5>Info Paket</h5>
                    <p>
                        Siswa ini terdaftar di paket: <strong>{{ $student->package }}</strong>.
                        <br>
                        <small>Perubahan jadwal dan paket dilakukan melalui halaman Absensi atau administrasi
                            khusus.</small>
                    </p>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('students.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Data Siswa</button>
                </div>
            </form>
        </div>
    </div>
@endsection
