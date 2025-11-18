@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit"></i> Edit Data Shift
        </h1>
        <a href="{{ route('shift.index') }}" class="btn btn-secondary btn-icon-split shadow-sm">
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
                        <i class="fas fa-edit"></i> Form Edit Data Shift
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('shift.update', $shift->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Nama Shift -->
                        <div class="form-group">
                            <label for="nama_shift" class="font-weight-bold">
                                Nama Shift <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nama_shift') is-invalid @enderror" 
                                   id="nama_shift" 
                                   name="nama_shift" 
                                   value="{{ old('nama_shift', $shift->nama_shift) }}" 
                                   placeholder="Contoh: Shift Pagi, Shift Siang, Shift Malam"
                                   required>
                            @error('nama_shift')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Jam Mulai -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jam_mulai" class="font-weight-bold">
                                        Jam Mulai <span class="text-danger">*</span>
                                    </label>
                                    <input type="time" 
                                           class="form-control @error('jam_mulai') is-invalid @enderror" 
                                           id="jam_mulai" 
                                           name="jam_mulai" 
                                           value="{{ old('jam_mulai', $shift->jam_mulai) }}"
                                           required>
                                    @error('jam_mulai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Jam Selesai -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jam_selesai" class="font-weight-bold">
                                        Jam Selesai <span class="text-danger">*</span>
                                    </label>
                                    <input type="time" 
                                           class="form-control @error('jam_selesai') is-invalid @enderror" 
                                           id="jam_selesai" 
                                           name="jam_selesai" 
                                           value="{{ old('jam_selesai', $shift->jam_selesai) }}"
                                           required>
                                    @error('jam_selesai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div class="form-group">
                            <label for="keterangan" class="font-weight-bold">
                                Keterangan
                            </label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                      id="keterangan" 
                                      name="keterangan" 
                                      rows="3" 
                                      placeholder="Tambahkan keterangan shift (opsional)">{{ old('keterangan', $shift->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <!-- Info Terakhir Diupdate -->
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Terakhir diupdate:</strong> {{ $shift->updated_at->format('d/m/Y H:i') }} WIB
                        </div>

                        <!-- Action Buttons -->
                        <div class="form-group text-right">
                            <a href="{{ route('shift.index') }}" class="btn btn-secondary">
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

    .text-danger {
        font-size: 1rem;
    }

    .alert {
        border-radius: 8px;
        border: none;
    }

    .alert-info {
        background-color: #d1ecf1;
        color: #0c5460;
    }
</style>
@endsection