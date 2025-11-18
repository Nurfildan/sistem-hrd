@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Potongan</h3>

    <form action="{{ route('potongan.update', $potongan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Potongan</label>
            <input type="text" name="nama_potongan" class="form-control" value="{{ $potongan->nama_potongan }}">
        </div>

        <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" value="{{ $potongan->jumlah }}">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('potongan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
