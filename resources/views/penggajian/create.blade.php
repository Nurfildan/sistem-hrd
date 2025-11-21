@extends('layouts.app')

@section('title', 'Tambah Penggajian')

@section('content')
<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Penggajian</h6>
        </div>

        <div class="card-body">

            <form action="{{ route('penggajian.store') }}" method="POST">
                @csrf

                <div class="row">

                    {{-- PILIH KARYAWAN --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold">Karyawan</label>
                        <select name="karyawan_id" class="form-control" required>
                            <option value="">-- Pilih Karyawan --</option>
                            @foreach ($karyawan as $k)
                                <option value="{{ $k->id }}">
                                    {{ $k->nama }} — {{ $k->jabatan->nama_jabatan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- BULAN --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold">Bulan Penggajian</label>
                        <input
                            type="month"
                            name="bulan"
                            class="form-control"
                            required
                        >
                    </div>

                </div>

                <div class="text-right">
                    <a href="{{ route('penggajian.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
