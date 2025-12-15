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

    <!-- Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <!-- Table -->
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
                            <th>Periode</th>
                            <th>Gaji Pokok</th>
                            <th>Tunjangan</th>
                            <th>Pot. Otomatis</th>
                            <th>Pot. Tambahan</th>
                            <th>Total Gaji</th>
                            <th>Status</th>
                            <th width="12%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($penggajian as $p)
                        <tr>
                            <td><strong>{{ $p->karyawan->nama }}</strong></td>
                            <td>{{ $p->periode }}</td>

                            <td>
                                <span class="badge badge-success">
                                    Rp {{ $p->gaji_pokok_formatted }}
                                </span>
                            </td>

                            <td>
                                <span class="badge badge-info">
                                    Rp {{ $p->tunjangan_formatted }}
                                </span>
                            </td>

                            <td>
                                <span class="badge badge-danger">
                                    Rp {{ $p->potongan_otomatis_formatted }}
                                </span>
                            </td>

                            <td>
                                <span class="badge badge-warning text-dark">
                                    Rp {{ $p->potongan_tambahan_formatted }}
                                </span>
                            </td>

                            <td>
                                <span class="badge badge-primary">
                                    Rp {{ $p->total_gaji_formatted }}
                                </span>
                            </td>

                            <td>
                                @if ($p->status_pembayaran === 'Sudah Dibayar')
                                    <span class="badge badge-success">Sudah Dibayar</span>
                                @else
                                    <span class="badge badge-warning text-dark">Belum Dibayar</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <a href="{{ route('penggajian.show', $p->id) }}"
                                   class="btn btn-info btn-sm"
                                   data-toggle="tooltip"
                                   title="Lihat Slip Gaji">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </a>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
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

@push('scripts')
<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        },
        pageLength: 10
    });

    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endpush
@endsection
