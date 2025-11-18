@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus-circle"></i> Tambah Jadwal Shift
        </h1>
        <a href="{{ route('karyawan_shift.index') }}" class="btn btn-secondary btn-icon-split shadow-sm">
            <span class="icon text-white-50">
                <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
    </div>

    <!-- Error -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> Terjadi kesalahan!
            <ul class="mt-2 mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Card Form -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit"></i> Form Tambah Jadwal Shift
                    </h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('karyawan_shift.store') }}" method="POST">
                        @csrf

                        <!-- Karyawan -->
                        <div class="form-group">
                            <label for="karyawan_id" class="font-weight-bold">
                                Pilih Karyawan <span class="text-danger">*</span>
                            </label>
                            <select name="karyawan_id" id="karyawan_id" 
                                    class="form-control @error('karyawan_id') is-invalid @enderror">
                                <option value="">-- Pilih Karyawan --</option>
                                @foreach($karyawan as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                @endforeach
                            </select>
                            @error('karyawan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Shift -->
                        <div class="form-group">
                            <label for="shift_id" class="font-weight-bold">
                                Pilih Shift <span class="text-danger">*</span>
                            </label>
                            <select name="shift_id" id="shift_id" 
                                    class="form-control @error('shift_id') is-invalid @enderror">
                                <option value="">-- Pilih Shift --</option>
                                @foreach($shift as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama_shift }}</option>
                                @endforeach
                            </select>
                            @error('shift_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal -->
                        <div class="form-group">
                            <label for="tanggal" class="font-weight-bold">
                                Tanggal <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="tanggal" id="tanggal" 
                                   class="form-control @error('tanggal') is-invalid @enderror">
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <!-- Buttons -->
                        <div class="form-group text-right">
                            <a href="{{ route('karyawan_shift.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="reset" class="btn btn-warning">
                                <i class="fas fa-redo"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Jadwal
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
</style>
@endsection
