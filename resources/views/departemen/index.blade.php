@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-building"></i> Data Departemen
        </h1>
        <a href="{{ route('departemen.create') }}" class="btn btn-primary btn-icon-split shadow-sm">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Departemen</span>
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <!-- Data Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Departemen</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Departemen</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($departemen as $key => $item)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td><strong>{{ $item->nama_departemen }}</strong></td>
                            <td class="text-center">
                                <a href="{{ route('departemen.edit', $item->id) }}" 
                                   class="btn btn-warning btn-sm" 
                                   data-toggle="tooltip" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('departemen.destroy', $item->id) }}" 
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus departemen?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" data-toggle="tooltip" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data departemen</p>
                                <a href="{{ route('departemen.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Tambah Departemen Pertama
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
    .btn-icon-split { border-radius: 10rem; overflow: hidden; }
    .btn-icon-split .icon { padding: 0.75rem; display: inline-flex; align-items: center; }
    .btn-icon-split .text { padding: 0.75rem 1.25rem; }
    .table thead th {
        border-bottom: 2px solid #4e73df;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
    }
    .table tbody tr:hover { background-color: #f8f9fc; }
    .card { border-radius: 10px; }
    .btn-sm { border-radius: 5px; }
</style>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            language: { url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json" }
        });
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endpush

@endsection
