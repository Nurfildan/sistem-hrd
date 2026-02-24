@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4">
        <i class="fas fa-plus-circle"></i> Tambah Aturan Potongan
    </h3>

    <div class="card shadow">
        <div class="card-body">

            <form action="{{ route('aturan-potongan.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Jabatan</label>
                    <select name="jabatan_id" class="form-control" required>
                        <option value="">-- Pilih Jabatan --</option>
                        @foreach($jabatan as $j)
                            <option value="{{ $j->id }}">
                                {{ $j->nama_jabatan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @include('aturan_potongan._form')

                <button class="btn btn-success mt-3">Simpan</button>
                <a href="{{ route('aturan-potongan.index') }}" class="btn btn-secondary mt-3">Kembali</a>
            </form>

        </div>
    </div>

</div>
@endsection
