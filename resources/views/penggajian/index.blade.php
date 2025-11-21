@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Penggajian</h6>
            <a href="{{ route('penggajian.create') }}" class="btn btn-primary btn-sm">+ Tambah</a>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Karyawan</th>
                        <th>Bulan</th>
                        <th>Gaji Pokok</th>
                        <th>Tunjangan</th>
                        <th>Potongan</th>
                        <th>Total Gaji</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($penggajian as $p)
                        <tr>
                            <td>{{ $p->karyawan->nama }}</td>
                            <td>{{ $p->bulan }}</td>
                            <td>Rp {{ number_format($p->gaji_pokok) }}</td>
                            <td>Rp {{ number_format($p->tunjangan) }}</td>
                            <td class="text-danger">Rp {{ number_format($p->potongan) }}</td>
                            <td class="text-success font-weight-bold">Rp {{ number_format($p->total_gaji) }}</td>
                            <td>{{ $p->status_pembayaran }}</td>
                            <td>
                                <a href="{{ route('penggajian.show', $p->id) }}" class="btn btn-info btn-sm">
                                    Slip Gaji
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
