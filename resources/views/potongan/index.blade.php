@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Daftar Potongan</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('potongan.generate', [date('m'), date('Y')]) }}" class="btn btn-success mb-3">
        Hitung Potongan Bulan Ini
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
                <th>Nama Potongan</th>
                <th>Jumlah</th>
                <th>Bulan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($potongan as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->karyawan->nama }}</td>
                <td>{{ $item->nama_potongan }}</td>
                <td>{{ number_format($item->jumlah,2) }}</td>
                <td>{{ $item->bulan }}</td>
                <td>
                    <a href="{{ route('potongan.karyawan', $item->karyawan_id) }}" class="btn btn-info btn-sm">Detail</a>
                    <a href="{{ route('potongan.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('potongan.destroy', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
