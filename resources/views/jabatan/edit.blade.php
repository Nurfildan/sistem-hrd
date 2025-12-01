@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit"></i> Edit Jabatan
        </h1>
        <a href="{{ route('jabatan.index') }}" class="btn btn-secondary btn-icon-split shadow-sm">
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
                        <i class="fas fa-edit"></i> Form Edit Jabatan
                    </h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('jabatan.update', $jabatan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="font-weight-bold">Nama Jabatan *</label>
                            <input type="text"
                                   name="nama_jabatan"
                                   value="{{ old('nama_jabatan', $jabatan->nama_jabatan) }}"
                                   class="form-control @error('nama_jabatan') is-invalid @enderror"
                                   required>
                            @error('nama_jabatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Gaji Pokok *</label>
                            <input type="text"
                                   name="gaji_pokok"
                                   value="{{ old('gaji_pokok', number_format($jabatan->gaji_pokok, 0, ',', '.')) }}"
                                   class="form-control @error('gaji_pokok') is-invalid @enderror"
                                   required>
                            @error('gaji_pokok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Tunjangan *</label>
                            <input type="text"
                                   name="tunjangan"
                                   value="{{ old('tunjangan', number_format($jabatan->tunjangan, 0, ',', '.')) }}"
                                   class="form-control @error('tunjangan') is-invalid @enderror"
                                   required>
                            @error('tunjangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <div class="text-right">
                            <button class="btn btn-warning" type="reset">
                                <i class="fas fa-redo"></i> Reset
                            </button>
                            <button class="btn btn-success" type="submit">
                                <i class="fas fa-save"></i> Update Data
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@push('scripts')
<script>
function formatRupiah(angka) {
    return angka.replace(/\D/g, "") // hanya angka
                .replace(/\B(?=(\d{3})+(?!\d))/g, "."); // titik ribuan
}

document.addEventListener("DOMContentLoaded", function () {
    const gajiInput = document.querySelector('input[name="gaji_pokok"]');
    const tunjInput = document.querySelector('input[name="tunjangan"]');

    function applyFormat(input) {
        input.addEventListener("input", function () {
            let raw = this.value.replace(/\./g, "");
            this.value = formatRupiah(raw);
        });
    }

    applyFormat(gajiInput);
    applyFormat(tunjInput);
});

document.addEventListener("DOMContentLoaded", function () {
    const gajiInput = document.querySelector('input[name="gaji_pokok"]');
    const tunjInput = document.querySelector('input[name="tunjangan"]');

    function formatRupiah(angka) {
        return angka
            .replace(/\D/g, "")
            .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function applyFormat(input) {
        // Format saat mengetik
        input.addEventListener("input", function () {
            let raw = this.value.replace(/\./g, "");
            this.value = formatRupiah(raw);
        });

        // Format ketika halaman pertama kali load
        input.value = formatRupiah(input.value.replace(/\./g, ""));
    }

    applyFormat(gajiInput);
    applyFormat(tunjInput);
});

</script>
@endpush
@endsection
