@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card shadow mb-4">
        <div class="card-header text-center">
            <h4>Slip Gaji Karyawan</h4>
            <small>Bulan: {{ $penggajian->bulan }}</small>
        </div>

        <div class="card-body">
            <h5>{{ $penggajian->karyawan->nama }}</h5>
            <p>Jabatan: {{ $penggajian->karyawan->jabatan->nama_jabatan }}</p>
            <hr>

            <table class="table">
                <tr>
                    <th>Gaji Pokok</th>
                    <td>Rp {{ number_format($penggajian->gaji_pokok) }}</td>
                </tr>

                <tr>
                    <th>Tunjangan</th>
                    <td>Rp {{ number_format($penggajian->tunjangan) }}</td>
                </tr>

                <tr>
                    <th>Potongan</th>
                    <td class="text-danger">Rp {{ number_format($penggajian->potongan) }}</td>
                </tr>

                <tr>
                    <th>Total Gaji</th>
                    <td class="text-success font-weight-bold">Rp {{ number_format($penggajian->total_gaji) }}</td>
                </tr>
            </table>

            <div class="text-center">
                <button onclick="window.print()" class="btn btn-primary">Print Slip</button>
            </div>
        </div>
    </div>

</div>
@endsection
