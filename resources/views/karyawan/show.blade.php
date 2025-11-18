@extends('layouts.app') {{-- atau layout utama kamu --}}
@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Detail Karyawan</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered mb-4">
                <tr>
                    <th style="width: 200px;">Nama Lengkap</th>
                    <td>{{ $karyawan->nama_lengkap }}</td>
                </tr>
                <tr>
                    <th>Jabatan</th>
                    <td>{{ $karyawan->jabatan }}</td>
                </tr>
                <tr>
                    <th>Departemen</th>
                    <td>{{ $karyawan->departemen }}</td>
                </tr>
                <tr>
                    <th>Tanggal Masuk</th>
                    <td>{{ \Carbon\Carbon::parse($karyawan->tanggal_masuk)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $karyawan->email }}</td>
                </tr>
                <tr>
                    <th>No. HP</th>
                    <td>{{ $karyawan->no_hp ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $karyawan->alamat ?? '-' }}</td>
                </tr>
                <tr>
    <th>Gaji Pokok</th>
    <td>
        Rp {{ number_format($karyawan->gaji_pokok, 0, ',', '.') }}
    </td>
</tr>

            </table>

            <div class="d-flex justify-content-between">
                <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">
                    ← Kembali
                </a>
                <div>
                    <a href="{{ route('karyawan.edit', $karyawan->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('karyawan.destroy', $karyawan->id) }}" 
                          method="POST" 
                          class="d-inline"
                          onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
