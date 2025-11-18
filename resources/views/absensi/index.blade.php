@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-check"></i> Data Absensi
        </h1>

        @if(Auth::user()->role === 'HRD')
        <a href="{{ route('absensi.tambah') }}" class="btn btn-primary btn-icon-split shadow-sm">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Absensi Manual</span>
        </a>
        @endif
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    {{-- TAMPILAN KHUSUS KARYAWAN --}}
    @if(Auth::user()->role === 'Karyawan')
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5><i class="fas fa-calendar-check"></i> Absensi Hari Ini</h5>

            @if($shiftHariIni)
                <p>Shift: <strong>{{ $shiftHariIni->shift->nama_shift }}</strong></p>
                <p>Jam: {{ $shiftHariIni->shift->jam_mulai }} - {{ $shiftHariIni->shift->jam_selesai }}</p>

                @if(!$sudahAbsen)
                    <form action="{{ route('absensi.masuk') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-sign-in-alt"></i>
                            </span>
                            <span class="text">Absen Masuk</span>
                        </button>
                    </form>
                @else
                    <span class="badge badge-success">Sudah Absen Hari Ini</span>

                    <form action="{{ route('absensi.keluar') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-sign-out-alt"></i>
                            </span>
                            <span class="text">Absen Keluar</span>
                        </button>
                    </form>
                @endif

            @else
                <p class="text-danger">Tidak ada jadwal shift hari ini.</p>
            @endif
        </div>
    </div>
    @endif

    {{-- FILTER HRD --}}
    @if(Auth::user()->role === 'HRD')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET">
                <div class="row">

                    <div class="col-md-3">
                        <label>Karyawan</label>
                        <select name="karyawan_id" class="form-control">
                            <option value="">Semua Karyawan</option>
                            @foreach($karyawanList as $k)
                                <option value="{{ $k->id }}" {{ request('karyawan_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label>Bulan</label>
                        <select name="bulan" class="form-control">
                            <option value="">Semua Bulan</option>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="Hadir" {{ request('status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                            <option value="Terlambat" {{ request('status') == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                            <option value="Izin" {{ request('status') == 'Izin' ? 'selected' : '' }}>Izin</option>
                            <option value="Sakit" {{ request('status') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                            <option value="Alpa" {{ request('status') == 'Alpa' ? 'selected' : '' }}>Alpa</option>
                        </select>
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary mr-2">Filter</button>
                        <a href="{{ route('absensi.index') }}" class="btn btn-secondary">Reset</a>
                    </div>

                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- TABEL ABSENSI -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Absensi</h6>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover" id="dataTable">
                <thead class="thead-light">
                    <tr>
                        <th>Tanggal</th>
                        @if(Auth::user()->role === 'HRD')
                        <th>Karyawan</th>
                        @endif
                        <th>Shift</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Status</th>
                        @if(Auth::user()->role === 'HRD')
                        <th width="15%">Aksi</th>
                        @endif
                    </tr>
                </thead>

                <tbody>
                    @forelse($absensi as $a)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($a->tanggal)->format('d-m-Y') }}</td>

                        @if(Auth::user()->role === 'HRD')
                        <td>{{ $a->karyawan->nama }}</td>
                        @endif

                        <td>{{ $a->shift->nama_shift }}</td>
                        <td><i class="fas fa-sign-in-alt text-success"></i> {{ $a->jam_masuk }}</td>
                        <td><i class="fas fa-sign-out-alt text-danger"></i> {{ $a->jam_keluar ?? '-' }}</td>

                        <td>
                            <span class="badge badge-{{ 
                                $a->status == 'Hadir' ? 'success' : 
                                ($a->status == 'Terlambat' ? 'warning' : 'danger')
                            }}">
                                {{ $a->status }}
                            </span>
                        </td>

                        @if(Auth::user()->role === 'HRD')
                        <td class="text-center">
                            <a href="{{ route('absensi.edit', $a->id) }}" class="btn btn-warning btn-sm" data-toggle="tooltip" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('absensi.destroy', $a->id) }}" class="d-inline" method="POST"
                                  onsubmit="return confirm('Yakin hapus absensi ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" data-toggle="tooltip" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ Auth::user()->role === 'HRD' ? '7' : '5' }}" class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data absensi</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $absensi->links() }}
        </div>
    </div>

</div>

{{-- STYLING AGAR MATCH --}}
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
    .badge {
        padding: 0.4rem 0.65rem;
        font-size: 0.75rem;
        font-weight: 600;
    }
</style>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "ordering": true,
            "pageLength": 10
        });

        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endpush

@endsection
