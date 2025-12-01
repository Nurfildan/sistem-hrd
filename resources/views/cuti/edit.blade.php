@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Edit Data Cuti</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('cuti.update', $cuti->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Karyawan <span class="text-danger">*</span></label>
                            <select name="karyawan_id" class="form-control @error('karyawan_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Karyawan --</option>
                                @foreach($karyawanList as $k)
                                    <option value="{{ $k->id }}" {{ $cuti->karyawan_id == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama }} ({{ $k->nip }})
                                    </option>
                                @endforeach
                            </select>
                            @error('karyawan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                   value="{{ old('tanggal_mulai', $cuti->tanggal_mulai) }}" required>
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                   value="{{ old('tanggal_selesai', $cuti->tanggal_selesai) }}" required>
                            @error('tanggal_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Keterangan <span class="text-danger">*</span></label>
                            <textarea name="keterangan" rows="4" class="form-control @error('keterangan') is-invalid @enderror" required>{{ old('keterangan', $cuti->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="Menunggu" {{ $cuti->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="Disetujui" {{ $cuti->status == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                <option value="Ditolak" {{ $cuti->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('cuti.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection