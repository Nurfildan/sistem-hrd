@extends('layouts.app')

@section('content')
<div class="container-fluid">
    
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit"></i> Edit Data Absensi
        </h1>
        <a href="{{ route('absensi.index') }}" class="btn btn-secondary btn-icon-split shadow-sm">
            <span class="icon text-white-50">
                <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <!-- Form Card -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-primary">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-clipboard-list"></i> Form Edit Absensi
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('absensi.update', $absensi->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label class="font-weight-bold text-gray-700">
                                <i class="fas fa-user text-primary"></i> Nama Karyawan
                            </label>
                            <input type="text" 
                                   class="form-control bg-light" 
                                   value="{{ $absensi->karyawan->nama ?? '-' }}" 
                                   disabled>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Data karyawan tidak dapat diubah
                            </small>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold text-gray-700">
                                <i class="fas fa-calendar text-primary"></i> Tanggal
                            </label>
                            <input type="text" 
                                   class="form-control bg-light" 
                                   value="{{ \Carbon\Carbon::parse($absensi->tanggal)->isoFormat('dddd, DD MMMM YYYY') }}" 
                                   disabled>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Tanggal tidak dapat diubah
                            </small>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold text-gray-700">
                                <i class="fas fa-clock text-primary"></i> Shift
                            </label>
                            <input type="text" 
                                   class="form-control bg-light" 
                                   value="{{ $absensi->shift->nama_shift ?? '-' }} ({{ $absensi->shift ? substr($absensi->shift->jam_mulai, 0, 5) . ' - ' . substr($absensi->shift->jam_selesai, 0, 5) : '-' }})" 
                                   disabled>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Data shift tidak dapat diubah
                            </small>
                        </div>

                        <hr class="my-4">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jam_masuk" class="font-weight-bold text-gray-700">
                                        <i class="fas fa-sign-in-alt text-success"></i> Jam Masuk
                                    </label>
                                    <input type="time" 
                                           name="jam_masuk" 
                                           id="jam_masuk" 
                                           class="form-control @error('jam_masuk') is-invalid @enderror" 
                                           value="{{ old('jam_masuk', $absensi->jam_masuk ? substr($absensi->jam_masuk, 0, 5) : '') }}">
                                    @error('jam_masuk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle"></i> Format: HH:MM (24 jam)
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jam_keluar" class="font-weight-bold text-gray-700">
                                        <i class="fas fa-sign-out-alt text-danger"></i> Jam Keluar
                                    </label>
                                    <input type="time" 
                                           name="jam_keluar" 
                                           id="jam_keluar" 
                                           class="form-control @error('jam_keluar') is-invalid @enderror" 
                                           value="{{ old('jam_keluar', $absensi->jam_keluar ? substr($absensi->jam_keluar, 0, 5) : '') }}">
                                    @error('jam_keluar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle"></i> Format: HH:MM (24 jam)
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="status" class="font-weight-bold text-gray-700">
                                <i class="fas fa-info-circle text-primary"></i> Status Kehadiran <span class="text-danger">*</span>
                            </label>
                            <select name="status" 
                                    id="status" 
                                    class="form-control @error('status') is-invalid @enderror" 
                                    required>
                                <option value="">-- Pilih Status --</option>
                                <option value="Hadir" {{ old('status', $absensi->status) == 'Hadir' ? 'selected' : '' }}>
                                    ✓ Hadir
                                </option>
                                <option value="Terlambat" {{ old('status', $absensi->status) == 'Terlambat' ? 'selected' : '' }}>
                                    ⚠ Terlambat
                                </option>
                                <option value="Izin" {{ old('status', $absensi->status) == 'Izin' ? 'selected' : '' }}>
                                    ℹ Izin
                                </option>
                                <option value="Sakit" {{ old('status', $absensi->status) == 'Sakit' ? 'selected' : '' }}>
                                    + Sakit
                                </option>
                                <option value="Alpa" {{ old('status', $absensi->status) == 'Alpa' ? 'selected' : '' }}>
                                    ✗ Alpa
                                </option>
                                <option value="Cuti" {{ old('status', $absensi->status) == 'Cuti' ? 'selected' : '' }}>
                                    ✈ Cuti
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Pilih status kehadiran karyawan
                            </small>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('absensi.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="col-lg-4">
            <!-- Data Karyawan Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-info">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-user-circle"></i> Informasi Karyawan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="text-xs font-weight-bold text-gray-600 text-uppercase mb-1">
                            Nama Lengkap
                        </div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                            {{ $absensi->karyawan->nama ?? '-' }}
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="mb-3">
                        <div class="text-xs font-weight-bold text-gray-600 text-uppercase mb-1">
                            Departemen
                        </div>
                        <div class="font-weight-bold text-gray-800">
                            <i class="fas fa-building text-primary"></i> 
                            {{ $absensi->karyawan->departemen->nama_departemen ?? '-' }}
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="mb-3">
                        <div class="text-xs font-weight-bold text-gray-600 text-uppercase mb-1">
                            Jabatan
                        </div>
                        <div class="font-weight-bold text-gray-800">
                            <i class="fas fa-briefcase text-info"></i> 
                            {{ $absensi->karyawan->jabatan->nama_jabatan ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Guide Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-warning">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-book"></i> Panduan Status
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <span class="badge badge-success mr-2">Hadir</span>
                            <small>Karyawan hadir tepat waktu</small>
                        </li>
                        <li class="mb-2">
                            <span class="badge badge-warning mr-2">Terlambat</span>
                            <small>Karyawan hadir namun terlambat</small>
                        </li>
                        <li class="mb-2">
                            <span class="badge badge-info mr-2">Izin</span>
                            <small>Karyawan izin dengan pemberitahuan</small>
                        </li>
                        <li class="mb-2">
                            <span class="badge badge-secondary mr-2">Sakit</span>
                            <small>Karyawan sakit dengan surat keterangan</small>
                        </li>
                        <li class="mb-2">
                            <span class="badge badge-danger mr-2">Alpa</span>
                            <small>Karyawan tidak hadir tanpa keterangan</small>
                        </li>
                        <li class="mb-0">
                            <span class="badge badge-primary mr-2">Cuti</span>
                            <small>Karyawan sedang cuti</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
    .btn-icon-split {
        padding: 0;
        overflow: hidden;
        border-radius: 10rem;
    }
    
    .btn-icon-split .icon {
        background: rgba(0, 0, 0, 0.15);
        padding: 0.5rem 0.75rem;
    }
    
    .btn-icon-split .text {
        padding: 0.5rem 1rem;
    }
    
    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
    
    .card-header.bg-primary,
    .card-header.bg-info,
    .card-header.bg-warning {
        border-bottom: none;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Auto-calculate status based on time
        $('#jam_masuk, #status').on('change', function() {
            const jamMasuk = $('#jam_masuk').val();
            const shiftStart = '{{ $absensi->shift ? substr($absensi->shift->jam_mulai, 0, 5) : "" }}';
            
            if (jamMasuk && shiftStart && $('#status').val() === '') {
                if (jamMasuk > shiftStart) {
                    $('#status').val('Terlambat');
                } else {
                    $('#status').val('Hadir');
                }
            }
        });
    });
</script>
@endpush