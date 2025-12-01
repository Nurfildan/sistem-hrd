@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-money-check-alt"></i> Data Penggajian
        </h1>

        <a href="{{ route('penggajian.create') }}" class="btn btn-primary btn-icon-split shadow-sm">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Penggajian</span>
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <!-- Data Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Penggajian</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered table-hover" id="dataTable">
                    <thead class="thead-light">
                        <tr>
                            <th>Karyawan</th>
                            <th>Bulan</th>
                            <th>Gaji Pokok</th>
                            <th>Tunjangan</th>
                            <th>Potongan</th>
                            <th>Total Gaji</th>
                            <th>Status</th>
                            <th width="12%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($penggajian as $p)
                        <tr>
                            <td><strong>{{ $p->karyawan->nama }}</strong></td>
                            <td>{{ $p->bulan }}</td>

                            <td>
                                <span class="badge badge-success">
                                    Rp {{ number_format($p->gaji_pokok, 0, ',', '.') }}
                                </span>
                            </td>

                            <td>
                                <span class="badge badge-info">
                                    Rp {{ number_format($p->tunjangan, 0, ',', '.') }}
                                </span>
                            </td>

                            <td>
                                <span class="badge badge-danger">
                                    Rp {{ number_format($p->potongan, 0, ',', '.') }}
                                </span>
                            </td>

                            <td>
                                <span class="badge badge-primary">
                                    Rp {{ number_format($p->total_gaji, 0, ',', '.') }}
                                </span>
                            </td>

                            <td>
                                @if ($p->status_pembayaran == 'Sudah Dibayar')
                                    <span class="badge badge-success">Sudah Dibayar</span>
                                @else
                                    <span class="badge badge-warning text-dark">Belum Dibayar</span>
                                @endif
                            </td>

                            <td class="text-center">

                                <a href="{{ route('penggajian.show', $p->id) }}"
                                   class="btn btn-info btn-sm"
                                   data-toggle="tooltip" title="Lihat Slip">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </a>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data penggajian</p>
                                <a href="{{ route('penggajian.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Tambah Penggajian Pertama
                                </a>
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
</style>

@push('scripts')
<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        "language": { "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json" },
        "pageLength": 10,
        "ordering": true,
        "searching": true
    });

    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endpush

@endsection
