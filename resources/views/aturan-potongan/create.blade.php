@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-plus"></i> Tambah Aturan Potongan
    </h1>

    <div class="card shadow">
        <div class="card-body">

            <form action="{{ route('aturan-potongan.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Jabatan</label>
                    <select name="jabatan_id" class="form-control" required>
                        <option value="">-- Pilih Jabatan --</option>
                        @foreach($jabatan as $j)
                            <option value="{{ $j->id }}">{{ $j->nama_jabatan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Potongan per Absen</label>
                    <input type="number" name="potongan_per_absen" class="form-control" min="0" required>
                </div>

                <button class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('aturan-potongan.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>
    </div>

</div>
@endsection
