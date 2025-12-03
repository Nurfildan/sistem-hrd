@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-circle"></i> Profilku
        </h1>
        <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-icon-split shadow-sm">
            <span class="icon text-white-50">
                <i class="fas fa-edit"></i>
            </span>
            <span class="text">Edit Profil</span>
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <!-- Card Foto Profil -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-body text-center">
                    <div class="profile-image-wrapper mb-3">
                        <img src="{{ $karyawan->foto ? asset('foto_karyawan/'.$karyawan->foto) : asset('img/default-avatar.png') }}" 
                             class="rounded-circle border shadow-sm" 
                             width="150" 
                             height="150" 
                             style="object-fit: cover;">
                    </div>
                    <h5 class="mb-1 font-weight-bold">{{ $karyawan->nama }}</h5>
                    <p class="text-muted mb-0 small">{{ $karyawan->nip }}</p>
                    <p class="text-primary font-weight-bold mb-3">{{ $karyawan->jabatan->nama_jabatan }}</p>
                    
                    <span class="badge badge-{{ $karyawan->status == 'Tetap' ? 'success' : ($karyawan->status == 'Kontrak' ? 'warning' : 'info') }} badge-lg">
                        {{ $karyawan->status }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Card Detail Profil -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle"></i> Informasi Detail
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong><i class="fas fa-id-card text-primary"></i> NIP</strong>
                        </div>
                        <div class="col-sm-8">{{ $karyawan->nip }}</div>
                    </div>
                    <hr>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong><i class="fas fa-user text-primary"></i> Nama Lengkap</strong>
                        </div>
                        <div class="col-sm-8">{{ $karyawan->nama }}</div>
                    </div>
                    <hr>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong><i class="fas fa-briefcase text-primary"></i> Jabatan</strong>
                        </div>
                        <div class="col-sm-8">{{ $karyawan->jabatan->nama_jabatan }}</div>
                    </div>
                    <hr>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong><i class="fas fa-building text-primary"></i> Departemen</strong>
                        </div>
                        <div class="col-sm-8">{{ $karyawan->departemen->nama_departemen }}</div>
                    </div>
                    <hr>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong><i class="fas fa-calendar text-primary"></i> Tanggal Masuk</strong>
                        </div>
                        <div class="col-sm-8">{{ \Carbon\Carbon::parse($karyawan->tgl_masuk)->format('d F Y') }}</div>
                    </div>
                    <hr>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong><i class="fas fa-user-tag text-primary"></i> Status</strong>
                        </div>
                        <div class="col-sm-8">
                            <span class="badge badge-{{ $karyawan->status == 'Tetap' ? 'success' : ($karyawan->status == 'Kontrak' ? 'warning' : 'info') }}">
                                {{ $karyawan->status }}
                            </span>
                        </div>
                    </div>
                    <hr>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong><i class="fas fa-phone text-primary"></i> No. HP</strong>
                        </div>
                        <div class="col-sm-8">{{ $karyawan->no_hp ?? '-' }}</div>
                    </div>
                    <hr>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong><i class="fas fa-envelope text-primary"></i> Email</strong>
                        </div>
                        <div class="col-sm-8">{{ $karyawan->email ?? '-' }}</div>
                    </div>
                    <hr>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong><i class="fas fa-map-marker-alt text-primary"></i> Alamat</strong>
                        </div>
                        <div class="col-sm-8">{{ $karyawan->alamat ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

    .alert {
        border-radius: 10px;
        border: none;
    }

    .card {
        border-radius: 10px;
        border: none;
    }

    .card-header {
        background-color: #f8f9fc;
        border-bottom: 2px solid #4e73df;
        border-radius: 10px 10px 0 0 !important;
    }

    .badge {
        padding: 0.35rem 0.65rem;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-lg {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }

    .profile-image-wrapper {
        position: relative;
        display: inline-block;
    }

    hr {
        margin: 0.75rem 0;
        border-top: 1px solid #e3e6f0;
    }
</style>
@endsection