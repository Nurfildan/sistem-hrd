@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus-circle"></i> Tambah Absensi Manual
        </h1>
        <a href="{{ route('absensi.index') }}" class="btn btn-secondary btn-icon-split shadow-sm">
            <span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
            <span class="text">Kembali</span>
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit"></i> Form Tambah Absensi (HRD)
                    </h6>
                </div>

                <div class="card-body">
                    <!-- tampilkan error global -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Terdapat kesalahan!</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('absensi.store') }}" method="POST">
                        @csrf

                        <!-- Karyawan -->
                        <div class="form-group">
                            <label for="karyawan_id" class="font-weight-bold">
                                Karyawan <span class="text-danger">*</span>
                            </label>
                            <select name="karyawan_id" id="karyawan_id" class="form-control @error('karyawan_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Karyawan --</option>
                                @foreach($karyawanList as $k)
                                    <option value="{{ $k->id }}" {{ old('karyawan_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('karyawan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <!-- Tanggal -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal" class="font-weight-bold">
                                        Tanggal <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="tanggal" id="tanggal"
                                           class="form-control @error('tanggal') is-invalid @enderror"
                                           value="{{ old('tanggal', now()->toDateString()) }}" required>
                                    @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Shift -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="shift_id" class="font-weight-bold">
                                        Shift <span class="text-danger">*</span>
                                    </label>
                                    <select name="shift_id" id="shift_id" class="form-control @error('shift_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Shift --</option>
                                        @foreach($shifts as $s)
                                            <option value="{{ $s->id }}" {{ old('shift_id') == $s->id ? 'selected' : '' }}>
                                                {{ $s->nama_shift }} ({{ $s->jam_mulai }} - {{ $s->jam_selesai }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('shift_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Jam Masuk -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jam_masuk" class="font-weight-bold">
                                        Jam Masuk <span class="text-danger">*</span>
                                    </label>
                                    <!-- gunakan input type=time agar format konsisten -->
                                    <input type="time" name="jam_masuk" id="jam_masuk"
                                           class="form-control @error('jam_masuk') is-invalid @enderror"
                                           value="{{ old('jam_masuk') }}" required>
                                    @error('jam_masuk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Jam Keluar (opsional) -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jam_keluar" class="font-weight-bold">
                                        Jam Keluar (Opsional)
                                    </label>
                                    <input type="time" name="jam_keluar" id="jam_keluar"
                                           class="form-control @error('jam_keluar') is-invalid @enderror"
                                           value="{{ old('jam_keluar') }}">
                                    @error('jam_keluar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="form-group">
                            <label for="status" class="font-weight-bold">
                                Status <span class="text-danger">*</span>
                            </label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="Hadir" {{ old('status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="Terlambat" {{ old('status') == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                                <option value="Izin" {{ old('status') == 'Izin' ? 'selected' : '' }}>Izin</option>
                                <option value="Sakit" {{ old('status') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="Alpa" {{ old('status') == 'Alpa' ? 'selected' : '' }}>Alpa</option>
                                <option value="Cuti" {{ old('status') == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <hr class="my-4">

                        <div class="form-group text-right">
                            <a href="{{ route('absensi.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="reset" class="btn btn-warning">
                                <i class="fas fa-redo"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Absensi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-icon-split { border-radius: 10rem; overflow: hidden; }
    .btn-icon-split .icon { padding: 0.75rem; display: inline-flex; align-items: center; }
    .btn-icon-split .text { padding: 0.75rem 1.25rem; }
    .card { border-radius: 10px; }
    .form-control { border-radius: 8px; }
    .form-control:focus { border-color: #4e73df; box-shadow: 0 0 0 0.2rem rgba(78,115,223,0.15); }
    label { color: #5a5c69; font-size: 0.9rem; }
    .text-danger { font-size: 1rem; }
</style>
@endsection
