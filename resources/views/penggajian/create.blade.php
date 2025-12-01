@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Header Halaman -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus-circle"></i> Tambah Penggajian
        </h1>
        <a href="{{ route('penggajian.index') }}" class="btn btn-secondary btn-icon-split shadow-sm">
            <span class="icon text-white-50">
                <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
    </div>

    <div class="row">
        <div class="col-lg-7 mx-auto">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit"></i> Form Tambah Penggajian
                    </h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('penggajian.store') }}" method="POST">
                        @csrf

                        <!-- PILIH KARYAWAN -->
                        <div class="form-group">
                            <label class="font-weight-bold">Karyawan *</label>
                            <select name="karyawan_id"
                                    class="form-control @error('karyawan_id') is-invalid @enderror"
                                    required>
                                <option value="">-- Pilih Karyawan --</option>
                                @foreach ($karyawan as $k)
                                    <option value="{{ $k->id }}">
                                        {{ $k->nama }} — {{ $k->jabatan->nama_jabatan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('karyawan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- BULAN PENGGAJIAN -->
                        <div class="form-group">
                            <label class="font-weight-bold">Bulan Penggajian *</label>
                            <input type="month"
                                   name="bulan"
                                   class="form-control @error('bulan') is-invalid @enderror"
                                   required>
                            @error('bulan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <!-- BUTTON -->
                        <div class="text-right">
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
@endsection
