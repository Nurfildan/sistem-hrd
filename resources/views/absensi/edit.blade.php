@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Edit Data Absensi</h4>
                </div>
                <div class="card-body">
                    
                    {{-- Error Messages --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('absensi.update', $absensi->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Karyawan --}}
                        <div class="mb-3">
                            <label for="karyawan_id" class="form-label">
                                Karyawan <span class="text-danger">*</span>
                            </label>
                            <select name="karyawan_id" id="karyawan_id" class="form-control @error('karyawan_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Karyawan --</option>
                                @foreach($karyawanList as $k)
                                    <option value="{{ $k->id }}" {{ old('karyawan_id', $absensi->karyawan_id) == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama }} ({{ $k->nip }})
                                    </option>
                                @endforeach
                            </select>
                            @error('karyawan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Shift --}}
                        <div class="mb-3">
                            <label for="shift_id" class="form-label">
                                Shift <span class="text-danger">*</span>
                            </label>
                            <select name="shift_id" id="shift_id" class="form-control @error('shift_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Shift --</option>
                                @foreach($shifts as $s)
                                    <option value="{{ $s->id }}" {{ old('shift_id', $absensi->shift_id) == $s->id ? 'selected' : '' }}>
                                        {{ $s->nama_shift }} ({{ $s->jam_mulai }} - {{ $s->jam_selesai }})
                                    </option>
                                @endforeach
                            </select>
                            @error('shift_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tanggal --}}
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">
                                Tanggal <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="tanggal" id="tanggal" 
                                   class="form-control @error('tanggal') is-invalid @enderror"
                                   value="{{ old('tanggal', $absensi->tanggal) }}" required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jam Masuk --}}
                        <div class="mb-3">
                            <label for="jam_masuk" class="form-label">
                                Jam Masuk <span class="text-danger">*</span>
                            </label>
                            <input type="time" name="jam_masuk" id="jam_masuk" 
                                   class="form-control @error('jam_masuk') is-invalid @enderror"
                                   value="{{ old('jam_masuk', $absensi->jam_masuk) }}" required>
                            @error('jam_masuk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jam Keluar --}}
                        <div class="mb-3">
                            <label for="jam_keluar" class="form-label">
                                Jam Keluar
                            </label>
                            <input type="time" name="jam_keluar" id="jam_keluar" 
                                   class="form-control @error('jam_keluar') is-invalid @enderror"
                                   value="{{ old('jam_keluar', $absensi->jam_keluar) }}">
                            <small class="text-muted">Kosongkan jika belum absen keluar</small>
                            @error('jam_keluar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="mb-3">
                            <label for="status" class="form-label">
                                Status <span class="text-danger">*</span>
                            </label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="Hadir" {{ old('status', $absensi->status) == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="Terlambat" {{ old('status', $absensi->status) == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                                <option value="Izin" {{ old('status', $absensi->status) == 'Izin' ? 'selected' : '' }}>Izin</option>
                                <option value="Sakit" {{ old('status', $absensi->status) == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="Alpa" {{ old('status', $absensi->status) == 'Alpa' ? 'selected' : '' }}>Alpa</option>
                                <option value="Cuti" {{ old('status', $absensi->status) == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('absensi.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Absensi
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection