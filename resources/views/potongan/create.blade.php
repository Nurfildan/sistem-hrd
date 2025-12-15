@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus-circle"></i> Tambah Potongan
        </h1>
        <a href="{{ route('potongan.index') }}" class="btn btn-secondary btn-icon-split shadow-sm">
            <span class="icon text-white-50">
                <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Potongan</h6>
        </div>

        <div class="card-body">
            <form action="{{ route('potongan.store') }}" method="POST">
                @csrf

                <!-- Karyawan -->
                <div class="form-group">
                    <label for="karyawan_id">Karyawan <span class="text-danger">*</span></label>
                    <select name="karyawan_id" id="karyawan_id" 
                            class="form-control @error('karyawan_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Karyawan --</option>
                        @foreach($karyawan as $k)
                            <option value="{{ $k->id }}" {{ old('karyawan_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('karyawan_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nama Potongan -->
                <div class="form-group">
                    <label for="nama_potongan">Nama Potongan <span class="text-danger">*</span></label>
                    <input type="text" name="nama_potongan" id="nama_potongan" 
                           class="form-control @error('nama_potongan') is-invalid @enderror" 
                           value="{{ old('nama_potongan') }}" 
                           placeholder="Contoh: Potongan Terlambat" required>
                    @error('nama_potongan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Jumlah -->
                <div class="form-group">
                    <label for="jumlah">Jumlah Potongan (Rp) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="text" id="jumlah_display" 
                               class="form-control @error('jumlah') is-invalid @enderror" 
                               placeholder="50.000" required>
                        <input type="hidden" name="jumlah" id="jumlah" value="{{ old('jumlah') }}">
                        @error('jumlah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="form-text text-muted">Masukkan nominal potongan</small>
                </div>

                <!-- Bulan -->
                <div class="form-group">
                    <label for="bulan">Bulan <span class="text-danger">*</span></label>
                    <input type="month" name="bulan" id="bulan" 
                           class="form-control @error('bulan') is-invalid @enderror" 
                           value="{{ old('bulan', date('Y-m')) }}" required>
                    <small class="form-text text-muted">Pilih bulan periode potongan</small>
                    @error('bulan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('potongan.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 10px;
    }

    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

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

    label {
        font-weight: 600;
        color: #5a5c69;
    }

    .text-danger {
        color: #e74a3b !important;
    }

    .input-group-text {
        background-color: #4e73df;
        color: white;
        font-weight: 600;
        border: 1px solid #4e73df;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const jumlahDisplay = document.getElementById('jumlah_display');
    const jumlahHidden = document.getElementById('jumlah');

    // Format angka dengan titik sebagai pemisah ribuan
    function formatRupiah(angka) {
        const numberString = angka.toString().replace(/[^,\d]/g, '');
        const split = numberString.split(',');
        const sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        const ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            const separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        return split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
    }

    // Event listener untuk input
    jumlahDisplay.addEventListener('keyup', function(e) {
        // Ambil nilai input
        let nilai = this.value;

        // Hilangkan semua karakter selain angka
        nilai = nilai.replace(/[^0-9]/g, '');

        // Simpan nilai asli (tanpa format) ke hidden input
        jumlahHidden.value = nilai;

        // Format dan tampilkan dengan titik
        this.value = formatRupiah(nilai);
    });

    // Set nilai awal jika ada old value
    @if(old('jumlah'))
        jumlahHidden.value = '{{ old('jumlah') }}';
        jumlahDisplay.value = formatRupiah('{{ old('jumlah') }}');
    @endif
});
</script>
@endsection