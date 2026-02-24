@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Page Heading --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-money-bill-wave"></i> Laporan Penggajian
        </h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.laporan.penggajian.export-pdf', request()->query()) }}"
               class="btn btn-danger btn-icon-split shadow-sm mr-2">
                <span class="icon text-white-50">
                    <i class="fas fa-file-pdf"></i>
                </span>
                <span class="text">Export PDF</span>
            </a>
            <a href="{{ route('admin.laporan.penggajian.export-excel', request()->query()) }}"
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
            <form method="GET" action="{{ route('admin.laporan.penggajian') }}" id="filterForm">
                <div class="row align-items-end">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="form-label font-weight-600 text-gray-700">
                            <i class="fas fa-calendar mr-1"></i> Periode
                        </label>
                        <input type="month"
                               name="periode"
                               class="form-control"
                               value="{{ request('periode') }}">
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="form-label font-weight-600 text-gray-700">
                            <i class="fas fa-user mr-1"></i> Karyawan
                        </label>
                        <select name="karyawan_id" class="form-control">
                            <option value="">-- Semua Karyawan --</option>
                            @foreach($penggajian->pluck('karyawan')->unique('id')->filter() as $karyawan)
                                <option value="{{ $karyawan->id }}"
                                    {{ request('karyawan_id') == $karyawan->id ? 'selected' : '' }}>
                                    {{ $karyawan->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="form-label font-weight-600 text-gray-700">
                            <i class="fas fa-info-circle mr-1"></i> Status Pembayaran
                        </label>
                        <select name="status_pembayaran" class="form-control">
                            <option value="">-- Semua Status --</option>
                            <option value="Belum Dibayar" {{ request('status_pembayaran') == 'Belum Dibayar' ? 'selected' : '' }}>Belum Dibayar</option>
                            <option value="Sudah Dibayar" {{ request('status_pembayaran') == 'Sudah Dibayar' ? 'selected' : '' }}>Sudah Dibayar</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.laporan.penggajian') }}"
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
    @if($penggajian->count() > 0)
    @php
        // Hitung total potongan manual dari relasi
        $totalPotonganManual = $penggajian->sum(function($item) {
            return $item->potongan->sum('jumlah');
        });
    @endphp
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Penggajian</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $penggajian->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-invoice-dollar fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Dibayarkan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($penggajian->where('status_pembayaran', 'Sudah Dibayar')->sum('total_gaji'), 0, ',', '.') }}
                            </div>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Belum Dibayar</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($penggajian->where('status_pembayaran', 'Belum Dibayar')->sum('total_gaji'), 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Keseluruhan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($penggajian->sum('total_gaji'), 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-coins fa-2x text-gray-300"></i>
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
                <i class="fas fa-table mr-1"></i> Data Penggajian
            </h6>
            @if(request('periode'))
                <small class="text-muted">
                    <i class="fas fa-calendar mr-1"></i>
                    Periode: {{ \Carbon\Carbon::parse(request('periode') . '-01')->format('F Y') }}
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
                            <th>Jabatan</th>
                            <th>Periode</th>
                            <th>Tanggal Gajian</th>
                            <th>Gaji Pokok</th>
                            <th>Tunjangan</th>
                            <th>Potongan</th>
                            <th>Total Gaji</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penggajian as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $item->nama_karyawan ?? $item->karyawan->nama ?? '-' }}</strong>
                            </td>
                            <td>{{ $item->nama_jabatan ?? '-' }}</td>
                            <td class="text-center">
                                @if($item->periode)
                                    <span class="badge badge-secondary">
                                        {{ \Carbon\Carbon::parse($item->periode . '-01')->format('M Y') }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">
                                {{ $item->tanggal_penggajian ? $item->tanggal_penggajian->format('d M Y') : '-' }}
                            </td>
                            <td class="text-right">
                                Rp {{ number_format($item->gaji_pokok, 0, ',', '.') }}
                            </td>
                            <td class="text-right">
                                Rp {{ number_format($item->tunjangan, 0, ',', '.') }}
                            </td>
                            <td class="text-right text-danger">
                                @php
                                    $totalPotongan = $item->potongan_otomatis + $item->potongan->sum('jumlah');
                                @endphp
                                Rp {{ number_format($totalPotongan, 0, ',', '.') }}
                            </td>
                            <td class="text-right">
                                <strong>Rp {{ number_format($item->total_gaji, 0, ',', '.') }}</strong>
                            </td>
                            <td class="text-center">
                                @php
                                    $statusMap = [
                                        'Belum Dibayar' => ['warning', 'hourglass-half', 'Belum Dibayar'],
                                        'Sudah Dibayar' => ['success', 'check-circle',   'Sudah Dibayar'],
                                    ];
                                    $s = $statusMap[$item->status_pembayaran] ?? ['secondary', 'question-circle', $item->status_pembayaran];
                                @endphp
                                <span class="badge badge-{{ $s[0] }}">
                                    <i class="fas fa-{{ $s[1] }} mr-1"></i>{{ $s[2] }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-5">
                                <i class="fas fa-search fa-3x text-muted mb-3 d-block"></i>
                                <p class="text-muted mb-0">Belum ada data penggajian</p>
                                <small class="text-muted">Coba ubah filter pencarian</small>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($penggajian->count() > 0)
                    <tfoot class="bg-light">
                        <tr>
                            <th colspan="5" class="text-right">TOTAL:</th>
                            <th class="text-right">Rp {{ number_format($penggajian->sum('gaji_pokok'), 0, ',', '.') }}</th>
                            <th class="text-right">Rp {{ number_format($penggajian->sum('tunjangan'), 0, ',', '.') }}</th>
                            <th class="text-right text-danger">
                                @php
                                    $grandTotalPotongan = $penggajian->sum('potongan_otomatis') + $penggajian->sum(function($item) {
                                        return $item->potongan->sum('jumlah');
                                    });
                                @endphp
                                Rp {{ number_format($grandTotalPotongan, 0, ',', '.') }}
                            </th>
                            <th class="text-right">
                                <strong>Rp {{ number_format($penggajian->sum('total_gaji'), 0, ',', '.') }}</strong>
                            </th>
                            <th></th>
                        </tr>
                    </tfoot>
                    @endif
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
    .table tfoot th {
        border-top: 2px solid #4e73df;
        font-weight: 700;
        font-size: 0.85rem;
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
    .border-left-info     { border-left: 4px solid #36b9cc !important; }
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
            "order": [[4, "desc"]]
        });

        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endpush

@endsection