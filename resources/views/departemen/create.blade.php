@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus-circle"></i> Tambah Departemen
        </h1>
        <a href="{{ route('departemen.index') }}" class="btn btn-secondary btn-icon-split shadow-sm">
            <span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
            <span class="text">Kembali</span>
        </a>
    </div>

    <div class="row">
        <div class="col-lg-7 mx-auto">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-building"></i> Form Tambah Departemen
                    </h6>
                </div>
                <div class="card-body">

                    <form action="{{ route('departemen.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label class="font-weight-bold">Nama Departemen <span class="text-danger">*</span></label>
                            <input type="text" name="nama_departemen"
                                   class="form-control @error('nama_departemen') is-invalid @enderror"
                                   placeholder="Contoh: Produksi, Keuangan, HRD"
                                   value="{{ old('nama_departemen') }}" required>

                            @error('nama_departemen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>
                        <div class="text-right">
                            <a href="{{ route('departemen.index') }}" class="btn btn-secondary">
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

<style>
    .card { border-radius: 10px; }
    .form-control { border-radius: 8px; }
    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78,115,223,0.15);
    }
</style>

@endsection
