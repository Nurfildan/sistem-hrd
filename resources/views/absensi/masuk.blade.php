@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-file-alt"></i> Detail Absensi
        </h1>
        <a href="{{ route('absensi.index') }}" class="btn btn-secondary btn-icon-split shadow-sm">
            <span class="icon text-white-50">
                <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
    </div>

    <!-- Detail Absensi Card -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle"></i> Informasi Absensi
                    </h6>
                    <span class="badge badge-{{ 
                        $absensi->status == 'Hadir' ? 'success' : 
                        ($absensi->status == 'Terlambat' ? 'warning' : 
                        ($absensi->status == 'Izin' || $absensi->status == 'Sakit' || $absensi->status == 'Cuti' ? 'info' : 'danger'))
                    }}" style="font-size: 1rem; padding: 0.5rem 1rem;">
                        {{ $absensi->status }}
                    </span>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-user-circle"></i> Data Karyawan
                            </h5>
                        </div>
                    </div>

                    <!-- Info Karyawan -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label class="text-muted mb-1">
                                    <i class="fas fa-user"></i> Nama Karyawan
                                </label>
                                <p class="font-weight-bold">{{ $absensi->karyawan->nama }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label class="text-muted mb-1">
                                    <i class="fas fa-briefcase"></i> Jabatan
                                </label>
                                <p class="font-weight-bold">{{ $absensi->karyawan->jabatan }}</p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Info Absensi -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-clipboard-check"></i> Data Absensi
                            </h5>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label class="text-muted mb-1">
                                    <i class="fas fa-calendar-day"></i> Tanggal
                                </label>
                                <p class="font-weight-bold">
                                    {{ \Carbon\Carbon::parse($absensi->tanggal)->isoFormat('dddd, D MMMM YYYY') }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label class="text-muted mb-1">
                                    <i class="fas fa-clock"></i> Shift
                                </label>
                                <p class="font-weight-bold">{{ $absensi->shift->nama_shift }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label class="text-muted mb-1">
                                    <i class="fas fa-business-time"></i> Jam Shift
                                </label>
                                <p class="font-weight-bold">
                                    {{ $absensi->shift->jam_mulai }} - {{ $absensi->shift->jam_selesai }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label class="text-muted mb-1">
                                    <i class="fas fa-info-circle"></i> Status Kehadiran
                                </label>
                                <p>
                                    <span class="badge badge-{{ 
                                        $absensi->status == 'Hadir' ? 'success' : 
                                        ($absensi->status == 'Terlambat' ? 'warning' : 
                                        ($absensi->status == 'Izin' || $absensi->status == 'Sakit' || $absensi->status == 'Cuti' ? 'info' : 'danger'))
                                    }}" style="font-size: 0.9rem; padding: 0.5rem 0.75rem;">
                                        {{ $absensi->status }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Jam Masuk & Keluar -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-stopwatch"></i> Waktu Absensi
                            </h5>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card border-left-success shadow-sm h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Jam Masuk
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <i class="fas fa-sign-in-alt"></i> {{ $absensi->jam_masuk }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-sign-in-alt fa-2x text-success"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-left-danger shadow-sm h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                Jam Keluar
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <i class="fas fa-sign-out-alt"></i> 
                                                {{ $absensi->jam_keluar ?? 'Belum Absen Keluar' }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-sign-out-alt fa-2x text-danger"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Timestamp -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label class="text-muted mb-1">
                                    <i class="fas fa-calendar-plus"></i> Dibuat Pada
                                </label>
                                <p class="font-weight-bold">
                                    {{ $absensi->created_at->isoFormat('D MMMM YYYY, HH:mm') }} WIB
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label class="text-muted mb-1">
                                    <i class="fas fa-edit"></i> Terakhir Diupdate
                                </label>
                                <p class="font-weight-bold">
                                    {{ $absensi->updated_at->isoFormat('D MMMM YYYY, HH:mm') }} WIB
                                </p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Action Buttons -->
                    @if(Auth::user()->role === 'HRD')
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('absensi.edit', $absensi->id) }}" class="btn btn-warning btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-edit"></i>
                                </span>
                                <span class="text">Edit Absensi</span>
                            </a>

                            <form action="{{ route('absensi.destroy', $absensi->id) }}" method="POST" class="d-inline" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus data absensi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                    <span class="text">Hapus Absensi</span>
                                </button>
                            </form>

                            <a href="{{ route('absensi.index') }}" class="btn btn-secondary btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-list"></i>
                                </span>
                                <span class="text">Lihat Semua</span>
                            </a>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>

{{-- STYLING AGAR MATCH --}}
<style>
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
    .detail-item {
        margin-bottom: 1rem;
    }
    .detail-item label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
    }
    .detail-item p {
        font-size: 1rem;
        margin-bottom: 0;
    }
    .badge {
        padding: 0.4rem 0.65rem;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }
    .border-left-danger {
        border-left: 0.25rem solid #e74a3b !important;
    }
    .card-body {
        padding: 1.5rem;
    }
</style>

@endsection