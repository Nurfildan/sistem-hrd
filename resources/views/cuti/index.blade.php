@extends('layouts.app')

@section('title', 'Data Cuti')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-calendar-alt"></i> 
            @if(Auth::user()->role === 'Karyawan')
                Pengajuan Cuti Saya
            @else
                Data Cuti Karyawan
            @endif
        </h1>

        @if(Auth::user()->role === 'Karyawan')
            <a href="{{ route('cuti.create') }}" class="btn btn-primary btn-icon-split shadow-sm">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Ajukan Cuti</span>
            </a>
        @endif
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

    <!-- Error Message -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <!-- Filter Section (HRD Only) -->
    @if(Auth::user()->role === 'HRD')
        <div class="card shadow mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('cuti.index') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="font-weight-bold">Karyawan</label>
                            <select name="karyawan_id" class="form-control">
                                <option value="">Semua Karyawan</option>
                                @foreach($karyawanList as $k)
                                    <option value="{{ $k->id }}" 
                                        {{ request('karyawan_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama }} ({{ $k->nip }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="font-weight-bold">Status</label>
                            <select name="status" class="form-control">
                                <option value="">Semua Status</option>
                                <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>

                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="fas fa-search"></i> Filter
                            </button>
                            <a href="{{ route('cuti.index') }}" class="btn btn-secondary">
                                <i class="fas fa-redo"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Data Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Cuti</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%">No</th>
                            @if(Auth::user()->role === 'HRD') 
                                <th>Karyawan</th> 
                            @endif
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Durasi</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($cuti as $i => $c)
                        <tr>
                            <td class="text-center">{{ $cuti->firstItem() + $i }}</td>

                            @if(Auth::user()->role === 'HRD')
                                <td><strong>{{ $c->karyawan->nama ?? '-' }}</strong></td>
                            @endif

                            <td>{{ \Carbon\Carbon::parse($c->tanggal_mulai)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($c->tanggal_selesai)->format('d M Y') }}</td>

                            <td>
                                <span class="badge badge-info">
                                    {{ \Carbon\Carbon::parse($c->tanggal_mulai)->diffInDays($c->tanggal_selesai) + 1 }} hari
                                </span>
                            </td>

                            <td>{{ Str::limit($c->keterangan, 40) }}</td>

                            <td>
                                @if($c->status == 'Menunggu')
                                    <span class="badge badge-warning">{{ $c->status }}</span>
                                @elseif($c->status == 'Disetujui')
                                    <span class="badge badge-success">{{ $c->status }}</span>
                                @else
                                    <span class="badge badge-danger">{{ $c->status }}</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <a href="{{ route('cuti.show', $c->id) }}" 
                                   class="btn btn-info btn-sm" data-toggle="tooltip" 
                                   title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @if(Auth::user()->role === 'HRD')
                                    @if($c->status == 'Menunggu')
                                        <button class="btn btn-success btn-sm" 
                                                data-toggle="modal" 
                                                data-target="#modalApprove{{ $c->id }}"
                                                title="Approve">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                    @endif

                                    <a href="{{ route('cuti.edit', $c->id) }}" 
                                       class="btn btn-warning btn-sm" data-toggle="tooltip" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('cuti.destroy', $c->id) }}" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus data cuti ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" data-toggle="tooltip" 
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>

                        {{-- MODAL APPROVAL --}}
                        @if(Auth::user()->role === 'HRD')
                        <div class="modal fade" id="modalApprove{{ $c->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">
                                            <i class="fas fa-check-circle"></i> Approval Cuti
                                        </h5>
                                        <button class="close text-white" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>

                                    <form action="{{ route('cuti.updateStatus', $c->id) }}" method="POST">
                                        @csrf 
                                        @method('PATCH')

                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="font-weight-bold">Karyawan:</label>
                                                <p>{{ $c->karyawan->nama }}</p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="font-weight-bold">Periode:</label>
                                                <p>{{ \Carbon\Carbon::parse($c->tanggal_mulai)->format('d M Y') }} 
                                                   s/d 
                                                   {{ \Carbon\Carbon::parse($c->tanggal_selesai)->format('d M Y') }}
                                                   ({{ \Carbon\Carbon::parse($c->tanggal_mulai)->diffInDays($c->tanggal_selesai) + 1 }} hari)
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="font-weight-bold">Keterangan:</label>
                                                <p>{{ $c->keterangan }}</p>
                                            </div>

                                            <hr>

                                            <div class="form-group">
                                                <label class="font-weight-bold">
                                                    Keputusan <span class="text-danger">*</span>
                                                </label>
                                                <select name="status" required class="form-control">
                                                    <option value="">-- Pilih Keputusan --</option>
                                                    <option value="Disetujui">Disetujui</option>
                                                    <option value="Ditolak">Ditolak</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                <i class="fas fa-times"></i> Batal
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save"></i> Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif

                        @empty
                            <tr>
                                <td colspan="{{ Auth::user()->role === 'HRD' ? 8 : 7 }}" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada data cuti</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($cuti->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $cuti->links() }}
                </div>
            @endif
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

    label {
        font-weight: 600;
        color: #5a5c69;
    }

    .modal-content {
        border-radius: 10px;
    }

    .modal-header {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
</style>

@push('scripts')
<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        },
        "pageLength": 10,
        "ordering": true,
        "searching": true
    });

    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endpush
@endsection