@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-edit"></i> Edit Data Karyawan
        </h1>
        <a href="{{ route('karyawan.index') }}" class="btn btn-secondary btn-icon-split shadow-sm">
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
                        <i class="fas fa-edit"></i> Form Edit Data Karyawan
                    </h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- NIP -->
                        <div class="form-group">
                            <label class="font-weight-bold">NIP <span class="text-danger">*</span></label>
                            <input type="text" name="nip"
                                   class="form-control @error('nip') is-invalid @enderror"
                                   value="{{ old('nip', $karyawan->nip) }}" required>
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nama -->
                        <div class="form-group">
                            <label class="font-weight-bold">Nama Karyawan <span class="text-danger">*</span></label>
                            <input type="text" name="nama"
                                   class="form-control @error('nama') is-invalid @enderror"
                                   value="{{ old('nama', $karyawan->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jabatan -->
                        <div class="form-group">
                            <label class="font-weight-bold">Jabatan <span class="text-danger">*</span></label>
                            <select name="jabatan_id"
                                    class="form-control @error('jabatan_id') is-invalid @enderror" required>
                                @foreach ($jabatan as $j)
                                    <option value="{{ $j->id }}"
                                        {{ $karyawan->jabatan_id == $j->id ? 'selected' : '' }}>
                                        {{ $j->nama_jabatan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jabatan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Departemen -->
                        <div class="form-group">
                            <label class="font-weight-bold">Departemen <span class="text-danger">*</span></label>
                            <select name="departemen_id"
                                    class="form-control @error('departemen_id') is-invalid @enderror" required>
                                @foreach ($departemen as $d)
                                    <option value="{{ $d->id }}"
                                        {{ $karyawan->departemen_id == $d->id ? 'selected' : '' }}>
                                        {{ $d->nama_departemen }}
                                    </option>
                                @endforeach
                            </select>
                            @error('departemen_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal Masuk -->
                        <div class="form-group">
                            <label class="font-weight-bold">Tanggal Masuk</label>
                            <input type="date" name="tgl_masuk"
                                   class="form-control @error('tgl_masuk') is-invalid @enderror"
                                   value="{{ old('tgl_masuk', $karyawan->tgl_masuk) }}">
                            @error('tgl_masuk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="form-group">
                            <label class="font-weight-bold">Status</label>
                            <select name="status" class="form-control">
                                <option value="Tetap"   {{ $karyawan->status == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                                <option value="Kontrak" {{ $karyawan->status == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                                <option value="Magang"  {{ $karyawan->status == 'Magang' ? 'selected' : '' }}>Magang</option>
                            </select>
                        </div>

                        <!-- No HP -->
                        <div class="form-group">
                            <label class="font-weight-bold">Nomor HP</label>
                            <input type="text" name="no_hp"
                                   class="form-control"
                                   value="{{ old('no_hp', $karyawan->no_hp) }}">
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label class="font-weight-bold">Email</label>
                            <input type="email" name="email"
                                   class="form-control"
                                   value="{{ old('email', $karyawan->email) }}">
                        </div>

                        <!-- Alamat -->
                        <div class="form-group">
                            <label class="font-weight-bold">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $karyawan->alamat) }}</textarea>
                        </div>

                        <!-- Foto -->
                        <div class="form-group">
                            <label class="font-weight-bold">Foto Baru (Opsional)</label>
                            <input type="file" name="foto" class="form-control">

                            @if ($karyawan->foto)
                                <p class="mt-2">Foto Saat Ini:</p>
                                <img src="{{ asset('foto_karyawan/' . $karyawan->foto) }}" width="130" class="img-thumbnail">
                            @endif
                        </div>

                        <hr class="my-4">

                        <!-- Info update -->
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            Terakhir diperbarui: {{ $karyawan->updated_at->format('d/m/Y H:i') }} WIB
                        </div>

                        <!-- Buttons -->
                        <div class="form-group text-right">
                            <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">
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

    .card { border-radius: 10px; }

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
