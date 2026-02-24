@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Page Heading --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-clipboard-list"></i> Laporan Absensi
        </h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.laporan.absensi.export-pdf', request()->query()) }}"
               class="btn btn-danger btn-icon-split shadow-sm mr-2">
                <span class="icon text-white-50">
                    <i class="fas fa-file-pdf"></i>
                </span>
                <span class="text">Export PDF</span>
            </a>
            <a href="{{ route('admin.laporan.absensi.export-excel', request()->query()) }}"
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
            <form method="GET" action="{{ route('admin.laporan.absensi') }}" id="filterForm">
                <div class="row align-items-end">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="form-label font-weight-600 text-gray-700">
                            <i class="fas fa-calendar-alt mr-1"></i> Tanggal Mulai
                        </label>
                        <input type="date"
                               name="tanggal_mulai"
                               class="form-control"
                               value="{{ request('tanggal_mulai') }}">
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="form-label font-weight-600 text-gray-700">
                            <i class="fas fa-calendar-alt mr-1"></i> Tanggal Selesai
                        </label>
                        <input type="date"
                               name="tanggal_selesai"
                               class="form-control"
                               value="{{ request('tanggal_selesai') }}">
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="form-label font-weight-600 text-gray-700">
                            <i class="fas fa-user mr-1"></i> Karyawan
                        </label>
                        <select name="karyawan_id" class="form-control">
                            <option value="">-- Semua Karyawan --</option>
                            @foreach($absensi->pluck('karyawan')->unique('id')->filter() as $karyawan)
                                <option value="{{ $karyawan->id }}"
                                    {{ request('karyawan_id') == $karyawan->id ? 'selected' : '' }}>
                                    {{ $karyawan->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="form-label font-weight-600 text-gray-700">
                            <i class="fas fa-info-circle mr-1"></i> Status
                        </label>
                        <select name="status" class="form-control">
                            <option value="">-- Semua Status --</option>
                            <option value="Hadir"      {{ request('status') == 'Hadir'      ? 'selected' : '' }}>Hadir</option>
                            <option value="Terlambat"  {{ request('status') == 'Terlambat'  ? 'selected' : '' }}>Terlambat</option>
                            <option value="Izin"       {{ request('status') == 'Izin'       ? 'selected' : '' }}>Izin</option>
                            <option value="Sakit"      {{ request('status') == 'Sakit'      ? 'selected' : '' }}>Sakit</option>
                            <option value="Alpa"       {{ request('status') == 'Alpa'       ? 'selected' : '' }}>Alpa</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 d-flex justify-content-end">
                        <a href="{{ route('admin.laporan.absensi') }}"
                           class="btn btn-secondary mr-2">
                            <i class="fas fa-undo"></i> Reset
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Tampilkan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Summary Cards --}}
    @if($absensi->count() > 0)
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Absensi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $absensi->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Hadir</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $absensi->where('status', 'Hadir')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Terlambat</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $absensi->where('status', 'Terlambat')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Alpa</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $absensi->where('status', 'Alpa')->count() }}</div>
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
                <i class="fas fa-table mr-1"></i> Data Absensi
            </h6>
            @if(request('tanggal_mulai') && request('tanggal_selesai'))
                <small class="text-muted">
                    <i class="fas fa-calendar mr-1"></i>
                    {{ \Carbon\Carbon::parse(request('tanggal_mulai'))->format('d M Y') }}
                    &mdash;
                    {{ \Carbon\Carbon::parse(request('tanggal_selesai'))->format('d M Y') }}
                </small>
            @endif
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th width="4%">No</th>
                            <th>Karyawan</th>
                            <th>Tanggal</th>
                            <th>Shift</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                            <th>Status</th>
                            <th>Terlambat</th>
                            <th>Sumber</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($absensi as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $item->karyawan->nama ?? '-' }}</strong>
                            </td>
                            <td>{{ $item->tanggal ? $item->tanggal->format('d M Y') : '-' }}</td>
                            <td>
                                @if($item->shift)
                                    <span class="badge badge-secondary">{{ $item->shift->nama_shift }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $item->jam_masuk ?? '-' }}</td>
                            <td>{{ $item->jam_keluar ?? '-' }}</td>
                            <td class="text-center">
                                @php
                                    $statusMap = [
                                        'Hadir'     => ['success', 'check-circle',  'Hadir'],
                                        'Terlambat' => ['warning', 'clock',         'Terlambat'],
                                        'Izin'      => ['info',    'info-circle',   'Izin'],
                                        'Sakit'     => ['primary', 'medkit',        'Sakit'],
                                        'Alpa'      => ['danger',  'times-circle',  'Alpa'],
                                    ];
                                    $s = $statusMap[$item->status] ?? ['secondary', 'question-circle', $item->status];
                                @endphp
                                <span class="badge badge-{{ $s[0] }}">
                                    <i class="fas fa-{{ $s[1] }} mr-1"></i>{{ $s[2] }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($item->terlambat_menit > 0)
                                    <span class="badge badge-warning">
                                        <i class="fas fa-clock mr-1"></i>{{ $item->terlambat_menit }} menit
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($item->sumber == 'Manual')
                                    <span class="badge badge-light border">
                                        <i class="fas fa-keyboard mr-1 text-secondary"></i>Manual
                                    </span>
                                @elseif($item->sumber == 'Auto')
                                    <span class="badge badge-light border">
                                        <i class="fas fa-fingerprint mr-1 text-primary"></i>Auto
                                    </span>
                                @else
                                    <span class="text-muted">{{ $item->sumber ?? '-' }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <i class="fas fa-search fa-3x text-muted mb-3 d-block"></i>
                                <p class="text-muted mb-0">Belum ada data absensi</p>
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
            "order": [[2, "desc"]]
        });

        // Validasi: tanggal selesai tidak boleh sebelum tanggal mulai
        $('input[name="tanggal_selesai"]').on('change', function () {
            const mulai = $('input[name="tanggal_mulai"]').val();
            const selesai = $(this).val();
            if (mulai && selesai && selesai < mulai) {
                alert('Tanggal selesai tidak boleh sebelum tanggal mulai!');
                $(this).val('');
            }
        });

        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endpush

@endsection