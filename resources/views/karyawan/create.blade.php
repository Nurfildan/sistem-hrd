@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-plus"></i> Tambah Karyawan Baru
        </h1>
        <a href="{{ route('karyawan.index') }}" class="btn btn-secondary btn-icon-split shadow-sm">
            <span class="icon text-white-50">
                <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
    </div>

    <div class="row">
        <div class="col-lg-9 mx-auto">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user"></i> Form Tambah Karyawan
                    </h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('karyawan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- NIP --}}
                        <div class="form-group">
                            <label class="font-weight-bold">NIP <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="nip" 
                                   class="form-control @error('nip') is-invalid @enderror"
                                   value="{{ old('nip') }}"
                                   required>
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nama --}}
                        <div class="form-group">
                            <label class="font-weight-bold">Nama <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="nama" 
                                   class="form-control @error('nama') is-invalid @enderror"
                                   value="{{ old('nama') }}"
                                   required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jabatan --}}
                        <div class="form-group">
                            <label class="font-weight-bold">Jabatan <span class="text-danger">*</span></label>
                            <select name="jabatan_id" class="form-control" required>
                                <option value="">-- Pilih Jabatan --</option>
                                @foreach ($jabatan as $j)
                                    <option value="{{ $j->id }}">{{ $j->nama_jabatan }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Departemen --}}
                        <div class="form-group">
                            <label class="font-weight-bold">Departemen <span class="text-danger">*</span></label>
                            <select name="departemen_id" class="form-control" required>
                                <option value="">-- Pilih Departemen --</option>
                                @foreach ($departemen as $d)
                                    <option value="{{ $d->id }}">{{ $d->nama_departemen }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tanggal Masuk --}}
                        <div class="form-group">
                            <label class="font-weight-bold">Tanggal Masuk</label>
                            <input type="date" 
                                   name="tgl_masuk" 
                                   class="form-control @error('tgl_masuk') is-invalid @enderror"
                                   value="{{ old('tgl_masuk') }}">
                            @error('tgl_masuk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="form-group">
                            <label class="font-weight-bold">Status</label>
                            <select name="status" class="form-control">
                                <option value="Tetap">Tetap</option>
                                <option value="Kontrak">Kontrak</option>
                                <option value="Magang">Magang</option>
                            </select>
                        </div>

                        {{-- Nomor HP --}}
                        <div class="form-group">
                            <label class="font-weight-bold">No HP</label>
                            <input type="text" 
                                   name="no_hp" 
                                   class="form-control"
                                   value="{{ old('no_hp') }}">
                        </div>

                        {{-- Email --}}
                        <div class="form-group">
                            <label class="font-weight-bold">Email</label>
                            <input type="email" 
                                   name="email" 
                                   class="form-control"
                                   value="{{ old('email') }}">
                        </div>

                        {{-- Alamat --}}
                        <div class="form-group">
                            <label class="font-weight-bold">Alamat</label>
                            <textarea name="alamat" 
                                      class="form-control" 
                                      rows="3">{{ old('alamat') }}</textarea>
                        </div>

                        {{-- Foto --}}
                        <div class="form-group">
                            <label class="font-weight-bold">Foto</label>
                            <input type="file" name="foto" class="form-control">
                        </div>

                        <hr class="my-4">

                        <!-- Tombol -->
                        <div class="form-group text-right">
                            <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="reset" class="btn btn-warning">
                                <i class="fas fa-redo"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Data
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- STYLE
---------------------------------------------------- --}}
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
</style>
@endsection
