@extends('layouts.app')

@section('content')
<div class="container-fluid">
    
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-clipboard-check"></i> Data Absensi
        </h1>
        
        @if(auth()->user()->karyawan_id)
        <div class="btn-group" role="group">
            <button onclick="absenMasuk()" class="btn btn-success btn-icon-split shadow-sm" id="btnAbsenMasuk">
                <span class="icon text-white-50">
                    <i class="fas fa-sign-in-alt"></i>
                </span>
                <span class="text">Absen Masuk</span>
            </button>
            <button onclick="absenKeluar()" class="btn btn-danger btn-icon-split shadow-sm ml-2" id="btnAbsenKeluar">
                <span class="icon text-white-50">
                    <i class="fas fa-sign-out-alt"></i>
                </span>
                <span class="text">Absen Keluar</span>
            </button>
        </div>
        @endif
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Absensi Hari Ini Card (User dengan karyawan_id) -->
    @if(auth()->user()->karyawan_id)
    <div class="row mb-4">
        <div class="col-xl-12">
            <div class="card shadow border-left-primary">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Absensi Hari Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ now()->isoFormat('dddd, D MMMM YYYY') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-day fa-3x text-gray-300"></i>
                        </div>
                    </div>
                    
                    @php
                        $todayAbsen = $absensi->where('tanggal', now()->toDateString())->first();
                    @endphp
                    
                    @if($todayAbsen)
                    <hr>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <div class="text-xs font-weight-bold text-gray-600 mb-1">Status</div>
                            <span class="badge badge-{{ $todayAbsen->status == 'Hadir' ? 'success' : ($todayAbsen->status == 'Terlambat' ? 'warning' : 'secondary') }} badge-pill">
                                {{ $todayAbsen->status }}
                            </span>
                        </div>
                        <div class="col-md-3">
                            <div class="text-xs font-weight-bold text-gray-600 mb-1">Jam Masuk</div>
                            <div class="font-weight-bold text-gray-800">
                                <i class="fas fa-clock text-success"></i> {{ $todayAbsen->jam_masuk ? substr($todayAbsen->jam_masuk, 0, 5) : '-' }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-xs font-weight-bold text-gray-600 mb-1">Jam Keluar</div>
                            <div class="font-weight-bold text-gray-800">
                                <i class="fas fa-clock text-danger"></i> {{ $todayAbsen->jam_keluar ? substr($todayAbsen->jam_keluar, 0, 5) : '-' }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-xs font-weight-bold text-gray-600 mb-1">Shift</div>
                            <div class="font-weight-bold text-gray-800">
                                <i class="fas fa-clock"></i> {{ $todayAbsen->shift->nama_shift ?? '-' }}
                            </div>
                        </div>
                    </div>
                    @else
                    <hr>
                    <div class="text-center py-3">
                        <i class="fas fa-info-circle text-gray-400 fa-2x mb-2"></i>
                        <p class="text-gray-600 mb-0">Anda belum melakukan absensi hari ini</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Filter dan Statistik (HRD Only) -->
    @if(auth()->user()->role === 'HRD')
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Absensi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $absensi->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Hadir
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $absensi->where('status', 'Hadir')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Terlambat
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $absensi->where('status', 'Terlambat')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Tidak Hadir
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $absensi->whereIn('status', ['Izin', 'Sakit', 'Alpa', 'Cuti'])->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Data Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table"></i> Riwayat Absensi
            </h6>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="filterStatus('all')">
                    <i class="fas fa-list"></i> Semua
                </button>
                <button type="button" class="btn btn-sm btn-outline-success" onclick="filterStatus('Hadir')">
                    <i class="fas fa-check"></i> Hadir
                </button>
                <button type="button" class="btn btn-sm btn-outline-warning" onclick="filterStatus('Terlambat')">
                    <i class="fas fa-clock"></i> Terlambat
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="filterStatus('other')">
                    <i class="fas fa-times"></i> Lainnya
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th width="12%">Tanggal</th>
                            @if(auth()->user()->role === 'HRD')
                            <th width="20%">Nama Karyawan</th>
                            @endif
                            <th width="15%">Shift</th>
                            <th class="text-center" width="10%">Jam Masuk</th>
                            <th class="text-center" width="10%">Jam Keluar</th>
                            <th class="text-center" width="12%">Status</th>
                            @if(auth()->user()->role === 'HRD')
                            <th class="text-center" width="10%">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($absensi as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                <i class="fas fa-calendar text-gray-400"></i>
                                {{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('DD MMM YYYY') }}
                            </td>
                            @if(auth()->user()->role === 'HRD')
                            <td class="font-weight-bold">{{ $item->karyawan->nama ?? '-' }}</td>
                            @endif
                            <td>
                                <span class="badge badge-{{ $item->shift_id == 1 ? 'primary' : ($item->shift_id == 2 ? 'warning' : ($item->shift_id == 3 ? 'info' : 'secondary')) }}">
                                    {{ $item->shift->nama_shift ?? '-' }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($item->jam_masuk)
                                    <span class="text-success font-weight-bold">
                                        <i class="fas fa-clock"></i> {{ substr($item->jam_masuk, 0, 5) }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($item->jam_keluar)
                                    <span class="text-danger font-weight-bold">
                                        <i class="fas fa-clock"></i> {{ substr($item->jam_keluar, 0, 5) }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @php
                                    $statusColor = match($item->status) {
                                        'Hadir' => 'success',
                                        'Terlambat' => 'warning',
                                        'Izin' => 'info',
                                        'Sakit' => 'secondary',
                                        'Alpa' => 'danger',
                                        'Cuti' => 'primary',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge badge-{{ $statusColor }} badge-pill px-3 py-2">
                                    {{ $item->status }}
                                </span>
                            </td>
                            @if(auth()->user()->role === 'HRD')
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('absensi.edit', $item->id) }}" 
                                       class="btn btn-sm btn-info" 
                                       data-toggle="tooltip" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="deleteAbsensi({{ $item->id }})" 
                                            class="btn btn-sm btn-danger" 
                                            data-toggle="tooltip" 
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role === 'HRD' ? '8' : '6' }}" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                                <p class="text-gray-600 mb-0">Belum ada data absensi</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Apakah Anda yakin ingin menghapus data absensi ini?</p>
                <p class="text-muted mb-0"><small>Data yang dihapus tidak dapat dikembalikan.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Batal
                </button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
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
    
    .alert {
        border-radius: 0.35rem;
        border: none;
    }
    
    .table-hover tbody tr:hover {
        background-color: #f8f9fc;
    }
    
    .badge-pill {
        font-size: 0.75rem;
        font-weight: 600;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#dataTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            },
            order: [[1, 'desc']], // Sort by tanggal descending
            pageLength: 25
        });
        
        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });

    // Absen Masuk
    function absenMasuk() {
        if (!confirm('Apakah Anda yakin ingin melakukan absen masuk?')) {
            return;
        }
        
        $('#btnAbsenMasuk').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Proses...');
        
        $.ajax({
            url: '{{ route("absensi.masuk") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                location.reload();
            },
            error: function(xhr) {
                $('#btnAbsenMasuk').prop('disabled', false).html('<span class="icon text-white-50"><i class="fas fa-sign-in-alt"></i></span><span class="text">Absen Masuk</span>');
                alert('Gagal melakukan absen masuk');
            }
        });
    }

    // Absen Keluar
    function absenKeluar() {
        if (!confirm('Apakah Anda yakin ingin melakukan absen keluar?')) {
            return;
        }
        
        $('#btnAbsenKeluar').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Proses...');
        
        $.ajax({
            url: '{{ route("absensi.keluar") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                location.reload();
            },
            error: function(xhr) {
                $('#btnAbsenKeluar').prop('disabled', false).html('<span class="icon text-white-50"><i class="fas fa-sign-out-alt"></i></span><span class="text">Absen Keluar</span>');
                alert('Gagal melakukan absen keluar');
            }
        });
    }

    // Delete Absensi
    function deleteAbsensi(id) {
        $('#deleteForm').attr('action', `/absensi/${id}`);
        $('#deleteModal').modal('show');
    }

    // Filter Status
    function filterStatus(status) {
        const table = $('#dataTable').DataTable();
        
        if (status === 'all') {
            table.column({{ auth()->user()->role === 'HRD' ? '6' : '5' }}).search('').draw();
        } else if (status === 'other') {
            table.column({{ auth()->user()->role === 'HRD' ? '6' : '5' }}).search('^(Izin|Sakit|Alpa|Cuti)$', true, false).draw();
        } else {
            table.column({{ auth()->user()->role === 'HRD' ? '6' : '5' }}).search('^' + status + '$', true, false).draw();
        }
    }
</script>
@endpush