@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-edit"></i> Edit Data Gaji</h1>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('gaji.update', $gaji->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <label>Karyawan</label>
                        <select name="karyawan_id" class="form-control" required>
                            @foreach($karyawan as $item)
                                <option value="{{ $item->id }}" {{ $gaji->karyawan_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Bulan</label>
                        <input type="text" name="bulan" class="form-control" value="{{ $gaji->bulan }}" required>
                    </div>
                    <div class="col-md-3">
                        <label>Tahun</label>
                        <input type="number" name="tahun" class="form-control" value="{{ $gaji->tahun }}" required>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-3">
                        <label>Gaji Pokok</label>
                        <input type="text" name="gaji_pokok" id="gaji_pokok" class="form-control rupiah" value="{{ number_format($gaji->gaji_pokok, 0, ',', '.') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label>Tunjangan</label>
                        <input type="text" name="tunjangan" id="tunjangan" class="form-control rupiah" value="{{ number_format($gaji->tunjangan, 0, ',', '.') }}">
                    </div>
                    <div class="col-md-3">
                        <label>Potongan</label>
                        <input type="text" name="potongan" id="potongan" class="form-control rupiah" value="{{ number_format($gaji->potongan, 0, ',', '.') }}">
                    </div>
                    <div class="col-md-3">
                        <label>Total Gaji</label>
                        <input type="text" name="total_gaji" id="total_gaji" class="form-control rupiah" value="{{ number_format($gaji->total_gaji, 0, ',', '.') }}" readonly>
                    </div>
                </div>

                <div class="mt-4 text-right">
                    <a href="{{ route('gaji.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Format dan hitung total
function formatRupiah(angka) {
    return angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
document.querySelectorAll('.rupiah').forEach(input => {
    input.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\./g, '');
        if (!isNaN(value) && value !== '') {
            e.target.value = formatRupiah(value);
        }
        hitungTotal();
    });
});
function hitungTotal() {
    let gaji = parseInt(document.getElementById('gaji_pokok').value.replace(/\./g,'')) || 0;
    let tunj = parseInt(document.getElementById('tunjangan').value.replace(/\./g,'')) || 0;
    let pot = parseInt(document.getElementById('potongan').value.replace(/\./g,'')) || 0;
    document.getElementById('total_gaji').value = formatRupiah(String(gaji + tunj - pot));
}
</script>
@endpush
@endsection
