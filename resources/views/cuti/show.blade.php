@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Detail Pengajuan Cuti</h4>
                </div>
                <div class="card-body">
                    
                    <table class="table table-bordered">
                        <tr>
                            <th width="200">Karyawan</th>
                            <td>{{ $cuti->karyawan->nama }} ({{ $cuti->karyawan->nip }})</td>
                        </tr>
                        <tr>
                            <th>Jabatan</th>
                            <td>{{ $cuti->karyawan->jabatan->nama_jabatan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Departemen</th>
                            <td>{{ $cuti->karyawan->departemen->nama_departemen ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Mulai</th>
                            <td>{{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->locale('id')->translatedFormat('l, d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Selesai</th>
                            <td>{{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->locale('id')->translatedFormat('l, d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Durasi</th>
                            <td>
                                @php
                                    $durasi = \Carbon\Carbon::parse($cuti->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($cuti->tanggal_selesai)) + 1;
                                @endphp
                                <strong>{{ $durasi }} hari</strong>
                            </td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $cuti->keterangan }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($cuti->status == 'Menunggu')
                                    <span class="badge bg-warning text-dark fs-6">{{ $cuti->status }}</span>
                                @elseif($cuti->status == 'Disetujui')
                                    <span class="badge bg-success fs-6">{{ $cuti->status }}</span>
                                @else
                                    <span class="badge bg-danger fs-6">{{ $cuti->status }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Pengajuan</th>
                            <td>{{ $cuti->created_at->locale('id')->translatedFormat('l, d F Y H:i') }}</td>
                        </tr>
                    </table>

                    <div class="mt-3">
                        <a href="{{ route('cuti.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection