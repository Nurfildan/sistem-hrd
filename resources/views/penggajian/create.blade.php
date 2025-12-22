@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus-circle"></i> Tambah Penggajian
        </h1>
        <a href="{{ route('penggajian.index') }}" class="btn btn-secondary btn-icon-split shadow-sm">
            <span class="icon text-white-50">
                <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit"></i> Form Penggajian
                    </h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('penggajian.store') }}" method="POST">
                        @csrf

                        <!-- Karyawan -->
                        <div class="form-group">
                            <label class="font-weight-bold">Karyawan *</label>
                            <select id="karyawan_id"
                                    name="karyawan_id"
                                    class="form-control"
                                    required>
                                <option value="">-- Pilih Karyawan --</option>
                                @foreach ($karyawan as $k)
                                    <option value="{{ $k->id }}">
                                        {{ $k->nama }} — {{ $k->jabatan->nama_jabatan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Periode -->
                        <div class="form-group">
                            <label class="font-weight-bold">Periode Gaji *</label>
                            <input type="month"
                                   id="periode"
                                   name="periode"
                                   class="form-control"
                                   required>
                        </div>

                        <hr>

                        <!-- PREVIEW -->
                        <div class="card bg-light mb-3">
                            <div class="card-body">
                                <h6 class="font-weight-bold text-primary">
                                    <i class="fas fa-calculator"></i> Preview Perhitungan
                                </h6>

                                <table class="table table-sm table-borderless mb-0">
                                    <tr>
                                        <td>Gaji Pokok</td>
                                        <td class="text-right" id="gaji_pokok">-</td>
                                    </tr>
                                    <tr>
                                        <td>Tunjangan</td>
                                        <td class="text-right" id="tunjangan">-</td>
                                    </tr>
                                    <tr>
                                        <td>Potongan Otomatis</td>
                                        <td class="text-right text-danger" id="potongan">-</td>
                                    </tr>
                                    <tr class="border-top">
                                        <th>Total Gaji</th>
                                        <th class="text-right text-primary" id="total">-</th>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- BUTTON -->
                        <div class="text-right">
                            <button type="reset" class="btn btn-warning">
                                <i class="fas fa-redo"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Penggajian
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

</div>

{{-- SCRIPT --}}
@push('scripts')
<script>
function hitungGaji() {
    let karyawan = document.getElementById('karyawan_id').value;
    let periode  = document.getElementById('periode').value;

    if (!karyawan || !periode) return;

    fetch(`{{ route('penggajian.hitung') }}?karyawan_id=${karyawan}&periode=${periode}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('gaji_pokok').innerText =
                'Rp ' + data.gaji_pokok.toLocaleString('id-ID');

            document.getElementById('tunjangan').innerText =
                'Rp ' + data.tunjangan.toLocaleString('id-ID');

            document.getElementById('potongan').innerText =
                'Rp ' + data.potongan_otomatis.toLocaleString('id-ID');

            document.getElementById('total').innerText =
                'Rp ' + data.total_gaji.toLocaleString('id-ID');
        });
}

document.getElementById('karyawan_id').addEventListener('change', hitungGaji);
document.getElementById('periode').addEventListener('change', hitungGaji);
</script>
@endpush
@endsection
