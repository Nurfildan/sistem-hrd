@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit"></i> Edit Potongan
        </h1>
        <a href="{{ route('potongan.index') }}" class="btn btn-secondary btn-icon-split shadow-sm">
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
                        <i class="fas fa-edit"></i> Form Edit Potongan
                    </h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('potongan.update', $potongan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="font-weight-bold">Nama Potongan *</label>
                            <input type="text"
                                   name="nama_potongan"
                                   value="{{ old('nama_potongan', $potongan->nama_potongan) }}"
                                   class="form-control @error('nama_potongan') is-invalid @enderror"
                                   required>
                            @error('nama_potongan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
    <label class="font-weight-bold">Jumlah *</label>

    <!-- INPUT ASLI (yang ditampilkan ke user) -->
    <input type="text"
           id="jumlah_format"
           value="{{ number_format($potongan->jumlah, 0, ',', '.') }}"
           class="form-control @error('jumlah') is-invalid @enderror"
           required>

    <!-- INPUT YANG DIKIRIM KE BACKEND -->
    <input type="hidden"
           name="jumlah"
           id="jumlah">

    @error('jumlah')
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
// Format angka ke rupiah
function formatRupiah(angka) {
    return angka
        .replace(/\D/g, "")                // hanya angka
        .replace(/\B(?=(\d{3})+(?!\d))/g, "."); // titik ribuan
}

document.addEventListener("DOMContentLoaded", function () {
    const inputRupiah = document.querySelector('#jumlah');

    function applyFormat(input) {
        // Format saat diketik
        input.addEventListener("input", function () {
            let raw = this.value.replace(/\./g, "");
            this.value = formatRupiah(raw);
        });

        // Format saat halaman pertama dibuka
        input.value = formatRupiah(input.value.replace(/\./g, ""));
    }

    applyFormat(inputRupiah);
});

document.addEventListener("DOMContentLoaded", function () {
    const displayInput = document.getElementById('jumlah_format');
    const realInput = document.getElementById('jumlah');

    function toRupiah(value) {
        return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Format saat mengetik
    displayInput.addEventListener("input", function () {
        let raw = this.value.replace(/\D/g, "");
        this.value = toRupiah(raw);
        realInput.value = raw; // kirim angka tanpa titik
    });

    // Set nilai awal
    let initial = displayInput.value.replace(/\D/g, "");
    displayInput.value = toRupiah(initial);
    realInput.value = initial;
});

</script>
@endpush

@endsection
