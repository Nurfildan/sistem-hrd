@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-users"></i> Data Karyawan
        </h1>
        <a href="{{ route('karyawan.create') }}" class="btn btn-primary btn-icon-split shadow-sm">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Karyawan</span>
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

    <!-- DataTales -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table"></i> Daftar Karyawan
            </h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Departemen</th>
                            <th>Tanggal Masuk</th>
                            <th>Status</th>
                            <th>No HP</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>Foto</th>
                            <th width="140px">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($karyawan as $k)
                        <tr>
                            <td>{{ $k->nip }}</td>
                            <td><strong>{{ $k->nama }}</strong></td>
                            <td>{{ $k->jabatan->nama_jabatan }}</td>
                            <td>{{ $k->departemen->nama_departemen }}</td>
                            <td>{{ $k->tgl_masuk }}</td>

                            <td>
                                <span class="badge 
                                    @if($k->status == 'Tetap') badge-success 
                                    @elseif($k->status == 'Kontrak') badge-warning 
                                    @else badge-info 
                                    @endif">
                                    {{ $k->status }}
                                </span>
                            </td>

                            <td>{{ $k->no_hp }}</td>
                            <td>{{ $k->email }}</td>
                            <td>{{ $k->alamat }}</td>

                            <td class="text-center">
                                @if ($k->foto)
                                    <img src="{{ asset('foto_karyawan/' . $k->foto) }}" 
                                         width="60" height="60" 
                                         class="rounded-circle border">
                                @else
                                    <span class="text-muted">Tidak ada</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <a href="{{ route('karyawan.edit', $k->id) }}" 
                                   class="btn btn-warning btn-sm" 
                                   data-toggle="tooltip"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('karyawan.destroy', $k->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data karyawan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" data-toggle="tooltip" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="11" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data karyawan.</p>
                                <a href="{{ route('karyawan.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Tambah Karyawan
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
