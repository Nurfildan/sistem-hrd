@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-plus"></i> Buat User Baru
        </h1>
        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-icon-split shadow-sm">
            <span class="icon text-white-50">
                <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow mb-4">

                <!-- Card Header -->
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit"></i> Form Data User
                    </h6>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <!-- Karyawan -->
                        <div class="form-group">
                            <label class="font-weight-bold">Karyawan (Opsional)</label>
                            <select name="karyawan_id" class="form-control">
                                <option value="">-- Tanpa Karyawan --</option>

                                @foreach ($karyawan as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nama -->
                        <div class="form-group mt-3">
                            <label class="font-weight-bold">Nama User <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}"
                                   placeholder="Masukkan nama user"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group mt-3">
                            <label class="font-weight-bold">Email <span class="text-danger">*</span></label>
                            <input type="email" 
                                   name="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}"
                                   placeholder="Masukkan email"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div class="form-group mt-3">
                            <label class="font-weight-bold">Role <span class="text-danger">*</span></label>
                            <select name="role" class="form-control @error('role') is-invalid @enderror">
                                <option value="Admin">Admin</option>
                                <option value="HRD">HRD</option>
                                <option value="Karyawan">Karyawan</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group mt-3">
                            <label class="font-weight-bold">Password <span class="text-danger">*</span></label>
                            <input type="password" 
                                   name="password" 
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Masukkan password"
                                   required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <!-- Buttons -->
                        <div class="form-group text-right">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="reset" class="btn btn-warning">
                                <i class="fas fa-redo"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan User
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
