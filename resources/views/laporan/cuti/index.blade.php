@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Page Heading --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-calendar-check"></i> Laporan Cuti
        </h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.laporan.cuti.export-pdf') }}"
               class="btn btn-danger btn-icon-split shadow-sm mr-2">
                <span class="icon text-white-50">
                    <i class="fas fa-file-pdf"></i>
                </span>
                <span class="text">Export PDF</span>
            </a>
            <a href="{{ route('admin.laporan.cuti.export-excel') }}"
               class="btn btn-success btn-icon-split shadow-sm">
                <span class="icon text-white-50">
                    <i class="fas fa-file-excel"></i>
                </span>
                <span class="text">Export Excel</span>
            </a>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center">
            <i class="fas fa-filter text-primary mr-2"></i>
            <h6 class="m-0 font-weight-bold text-primary">Filter Laporan</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.laporan.cuti') }}" id="filterForm">
                <div class="row align-items-end">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <label class="form-label font-weight-600 text-gray-700">
                            <i class="fas fa-info-circle mr-1"></i> Status
                        </label>
                        <select name="status" class="form-control">
                            <option value="">-- Semua Status --</option>
                            <option value="Menunggu"  {{ request('status') == 'Menunggu'  ? 'selected' : '' }}>Menunggu</option>
                            <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="Ditolak"   {{ request('status') == 'Ditolak'   ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <label class="form-label font-weight-600 text-gray-700">
                            <i class="fas fa-user mr-1"></i> Karyawan
                        </label>
                        <select name="karyawan_id" class="form-control">
                            <option value="">-- Semua Karyawan --</option>
                            @foreach($cuti->pluck('karyawan')->unique('id')->filter() as $karyawan)
                                <option value="{{ $karyawan->id }}"
                                    {{ request('karyawan_id') == $karyawan->id ? 'selected' : '' }}>
                                    {{ $karyawan->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.laporan.cuti') }}"
                               class="btn btn-secondary mr-2">
                                <i class="fas fa-undo"></i> Reset
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Tampilkan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Summary Cards --}}
    @if($cuti->count() > 0)
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pengajuan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $cuti->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $cuti->where('status', 'Menunggu')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Disetujui</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $cuti->where('status', 'Disetujui')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Ditolak</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $cuti->where('status', 'Ditolak')->count() }}</div>
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

    {{-- Tabel Laporan --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table mr-1"></i> Data Pengajuan Cuti
            </h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th width="4%">No</th>
                            <th>Karyawan</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Durasi</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Disetujui Oleh</th>
                            <th>Tanggal Diajukan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cuti as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $item->karyawan->nama ?? '-' }}</strong>
                            </td>
                            <td>{{ $item->tanggal_mulai ? $item->tanggal_mulai->format('d M Y') : '-' }}</td>
                            <td>{{ $item->tanggal_selesai ? $item->tanggal_selesai->format('d M Y') : '-' }}</td>
                            <td class="text-center">
                                @if($item->tanggal_mulai && $item->tanggal_selesai)
                                    @php
                                        $durasi = $item->tanggal_mulai->diffInDays($item->tanggal_selesai) + 1;
                                    @endphp
                                    <span class="badge badge-info">{{ $durasi }} hari</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <small>{{ $item->keterangan ? Str::limit($item->keterangan, 50) : '-' }}</small>
                            </td>
                            <td class="text-center">
                                @php
                                    $statusMap = [
                                        'Menunggu'  => ['warning', 'hourglass-half', 'Menunggu'],
                                        'Disetujui' => ['success', 'check-circle',   'Disetujui'],
                                        'Ditolak'   => ['danger',  'times-circle',   'Ditolak'],
                                    ];
                                    $s = $statusMap[$item->status] ?? ['secondary', 'question-circle', $item->status];
                                @endphp
                                <span class="badge badge-{{ $s[0] }}">
                                    <i class="fas fa-{{ $s[1] }} mr-1"></i>{{ $s[2] }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($item->status == 'Disetujui' && $item->approver)
                                    <small>{{ $item->approver->name }}</small>
                                    <br>
                                    <small class="text-muted">{{ $item->approved_at ? $item->approved_at->format('d M Y') : '' }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <small>{{ $item->created_at->format('d M Y H:i') }}</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <i class="fas fa-search fa-3x text-muted mb-3 d-block"></i>
                                <p class="text-muted mb-0">Belum ada data pengajuan cuti</p>
                                <small class="text-muted">Coba ubah filter pencarian</small>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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
    .table thead th {
        border-bottom: 2px solid #4e73df;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    .table tbody tr:hover {
        background-color: #f8f9fc;
    }
    .badge {
        padding: 0.35rem 0.65rem;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .alert {
        border-radius: 10px;
        border: none;
    }
    .card {
        border-radius: 10px;
    }
    .btn-sm {
        border-radius: 5px;
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
    }
    .form-label {
        font-size: 0.85rem;
        margin-bottom: 0.4rem;
        display: block;
    }
    .font-weight-600 {
        font-weight: 600;
    }
    .border-left-primary  { border-left: 4px solid #4e73df !important; }
    .border-left-success  { border-left: 4px solid #1cc88a !important; }
    .border-left-warning  { border-left: 4px solid #f6c23e !important; }
    .border-left-danger   { border-left: 4px solid #e74a3b !important; }
</style>

@push('scripts')
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "pageLength": 25,
            "ordering": true,
            "searching": true,
            "order": [[8, "desc"]]
        });

        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endpush

@endsection