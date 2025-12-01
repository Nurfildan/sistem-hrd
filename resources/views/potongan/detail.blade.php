@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Detail Potongan: {{ $karyawan->nama }}</h3>

    <h5>Absensi</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($karyawan->absensi as $abs)
            <tr>
                <td>{{ $abs->tanggal }}</td>
                <td>{{ $abs->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h5>Cuti</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($karyawan->cuti as $c)
            <tr>
                <td>{{ $c->tanggal_mulai }}</td>
                <td>{{ $c->tanggal_selesai }}</td>
                <td>{{ $c->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h5>Potongan</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Potongan</th>
                <th>Jumlah</th>
                <th>Bulan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($karyawan->potongan as $p)
            <tr>
                <td>{{ $p->nama_potongan }}</td>
                <td>{{ number_format($p->jumlah,2) }}</td>
                <td>{{ $p->bulan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('potongan.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
