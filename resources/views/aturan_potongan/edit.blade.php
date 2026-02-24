@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4">
        <i class="fas fa-edit"></i> Edit Aturan Potongan
    </h3>

    <div class="card shadow">
        <div class="card-body">

            <form action="{{ route('aturan-potongan.update', $aturan_potongan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Jabatan</label>
                    <input type="text" 
                           class="form-control" 
                           value="{{ $aturan_potongan->jabatan->nama_jabatan }}" 
                           disabled>
                </div>

                @include('aturan_potongan._form', ['data' => $aturan_potongan])

                <button class="btn btn-primary mt-3">Update</button>
                <a href="{{ route('aturan-potongan.index') }}" class="btn btn-secondary mt-3">Kembali</a>
            </form>

        </div>
    </div>

</div>
@endsection
