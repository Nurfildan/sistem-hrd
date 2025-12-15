@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit"></i> Edit Data Cuti
        </h1>
        <a href="{{ route('cuti.index') }}" class="btn btn-secondary btn-icon-split shadow-sm">
            <span class="icon text-white-50">
                <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit"></i> Form Edit Data Cuti
                    </h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('cuti.update', $cuti->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Karyawan -->
                        <div class="form-group">
                            <label class="font-weight-bold">Karyawan <span class="text-danger">*</span></label>
                            <select name="karyawan_id" 
                                    class="form-control @error('karyawan_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Karyawan --</option>
                                @foreach($karyawanList as $k)
                                    <option value="{{ $k->id }}" 
                                        {{ old('karyawan_id', $cuti->karyawan_id) == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama }} ({{ $k->nip }})
                                    </option>
                                @endforeach
                            </select>
                            @error('karyawan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal Mulai -->
                        <div class="form-group">
                            <label class="font-weight-bold">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_mulai" 
                                   class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                   value="{{ old('tanggal_mulai', $cuti->tanggal_mulai) }}" required>
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal Selesai -->
                        <div class="form-group">
                            <label class="font-weight-bold">Tanggal Selesai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_selesai" 
                                   class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                   value="{{ old('tanggal_selesai', $cuti->tanggal_selesai) }}" required>
                            @error('tanggal_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Keterangan -->
                        <div class="form-group">
                            <label class="font-weight-bold">Keterangan <span class="text-danger">*</span></label>
                            <textarea name="keterangan" rows="4" 
                                      class="form-control @error('keterangan') is-invalid @enderror" 
                                      required>{{ old('keterangan', $cuti->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="form-group">
                            <label class="font-weight-bold">Status <span class="text-danger">*</span></label>
                            <select name="status" 
                                    class="form-control @error('status') is-invalid @enderror" required>
                                <option value="Menunggu" {{ old('status', $cuti->status) == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="Disetujui" {{ old('status', $cuti->status) == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                <option value="Ditolak" {{ old('status', $cuti->status) == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <!-- Info update -->
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            Terakhir diperbarui: {{ $cuti->updated_at->format('d/m/Y H:i') }} WIB
                        </div>

                        <!-- Buttons -->
                        <div class="form-group text-right">
                            <a href="{{ route('cuti.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>

                            <button type="reset" class="btn btn-warning">
                                <i class="fas fa-redo"></i> Reset
                            </button>

                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Update Data
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-icon-split {
        border-radius: 10rem;
        overflow: hidden;
    }
    .btn-icon-split .icon {
        padding: 0.75rem;
        display: inline-flex;
        align-items: center;
    }
    .btn-icon-split .text {
        padding: 0.75rem 1.25rem;
    }

    .card { 
        border-radius: 10px; 
    }

    .form-control {
        border-radius: 8px;
    }
    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15);
    }

    label {
        color: #5a5c69;
        font-size: 0.9rem;
    }
    
    .alert {
        border-radius: 8px;
        border: none;
    }
</style>

@endsection