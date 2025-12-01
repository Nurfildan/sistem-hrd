@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus-circle"></i> Tambah Jabatan Baru
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
                        <i class="fas fa-edit"></i> Form Data Jabatan
                    </h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('jabatan.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label class="font-weight-bold">Nama Jabatan *</label>
                            <input type="text" 
                                   name="nama_jabatan"
                                   class="form-control @error('nama_jabatan') is-invalid @enderror"
                                   placeholder="Contoh: Manager, Staff HRD"
                                   required>
                            @error('nama_jabatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Gaji Pokok *</label>
                            <input type="text" 
                                   name="gaji_pokok"
                                   class="form-control @error('gaji_pokok') is-invalid @enderror"
                                   placeholder="Contoh: 5000000"
                                   required>
                            @error('gaji_pokok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Tunjangan *</label>
                            <input type="text" 
                                   name="tunjangan"
                                   class="form-control @error('tunjangan') is-invalid @enderror"
                                   placeholder="Contoh: 1000000"
                                   required>
                            @error('tunjangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

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
</script>
@endpush
@endsection
