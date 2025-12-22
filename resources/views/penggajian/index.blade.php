@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-money-check-alt"></i> Penggajian Periode
            </h1>
        </div>

        <!-- Filter Periode -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('penggajian.index') }}" class="form-inline">
                    <div class="form-group mr-2">
                        <input type="month" name="periode" value="{{ $periode }}" class="form-control">
                    </div>
                    <button class="btn btn-primary btn-icon-split shadow-sm">
                        <span class="icon text-white-50">
                            <i class="fas fa-search"></i>
                        </span>
                        <span class="text">Tampilkan</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Generate Gaji -->
        <div class="mb-3">
            <form method="POST" action="{{ route('penggajian.generate') }}">
                @csrf
                <input type="hidden" name="periode" value="{{ $periode }}">
                <button class="btn btn-success btn-icon-split shadow-sm">
                    <span class="icon text-white-50">
                        <i class="fas fa-cogs"></i>
                    </span>
                    <span class="text">Generate Gaji {{ $periode }}</span>
                </button>
            </form>
        </div>

        <!-- Table Penggajian -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-money-check-alt"></i> Data Penggajian
                </h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center">No</th>
                                <th>Karyawan</th>
                                <th>Periode</th>
                                <th>Gaji Pokok</th>
                                <th>Tunjangan</th>
                                <th>Total Potongan</th>
                                <th>Total Gaji</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penggajian as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="font-weight-bold">{{ $item->karyawan->nama }}</td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ $item->periode }}
                                        </span>
                                    </td>
                                    <td>Rp {{ number_format($item->gaji_pokok, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($item->tunjangan, 0, ',', '.') }}</td>
                                    <td class="text-danger">
                                        Rp {{ number_format($item->potongan_otomatis + $item->potongan_tambahan, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <span class="badge badge-success">
                                            Rp {{ number_format($item->total_gaji, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('penggajian.show', $item->id) }}"
                                            class="btn btn-info btn-sm btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                            <span class="text">Detail</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        Belum ada data penggajian
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