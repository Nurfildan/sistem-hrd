@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-file-invoice-dollar"></i> Detail Penggajian
        </h1>
        <a href="{{ route('penggajian.index') }}" class="btn btn-secondary btn-icon-split shadow-sm">
            <span class="icon text-white-50">
                <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
    </div>

    <!-- Detail Gaji -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-user"></i> Informasi Penggajian
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama:</strong> {{ $penggajian->karyawan->nama }}</p>
                    <p><strong>Periode:</strong> {{ $penggajian->periode }}</p>
                    <p><strong>Gaji Pokok:</strong> Rp {{ number_format($penggajian->gaji_pokok,0,',','.') }}</p>
                    <p><strong>Tunjangan:</strong> Rp {{ number_format($penggajian->tunjangan,0,',','.') }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Potongan Otomatis:</strong> Rp {{ number_format($penggajian->potongan_otomatis,0,',','.') }}</p>
                    <p><strong>Potongan Tambahan:</strong> Rp {{ number_format($penggajian->potongan_tambahan,0,',','.') }}</p>
                    <hr>
                    <h5 class="text-gray-800">Total Gaji</h5>
                    <h3 class="text-success font-weight-bold">
                        Rp {{ number_format($penggajian->total_gaji,0,',','.') }}
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Potongan Tambahan -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-danger">
                <i class="fas fa-minus-circle"></i> Potongan Tambahan
            </h6>
        </div>
        <div class="card-body">

            <!-- Form Potongan -->
            <form action="{{ route('potongan.store') }}" method="POST" class="mb-4">
                @csrf
                <input type="hidden" name="penggajian_id" value="{{ $penggajian->id }}">

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Nama Potongan</label>
                        <input type="text" name="nama_potongan" class="form-control" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" required>
                    </div>
                    <div class="form-group col-md-5">
                        <label>Keterangan</label>
                        <input type="text" name="keterangan" class="form-control">
                    </div>
                </div>

                <button class="btn btn-danger btn-icon-split shadow-sm">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Tambah Potongan</span>
                </button>
            </form>

            <!-- List Potongan -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penggajian->potongan as $p)
                        <tr>
                            <td>{{ $p->nama_potongan }}</td>
                            <td class="text-danger">
                                Rp {{ number_format($p->jumlah,0,',','.') }}
                            </td>
                            <td>{{ $p->keterangan }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">
                                Belum ada potongan tambahan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection
