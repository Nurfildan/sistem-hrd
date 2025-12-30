@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h4 class="mb-4">
        <i class="fas fa-calendar-check"></i> Absensi Hari Ini
    </h4>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Tidak ada jadwal --}}
    @if(!$jadwal)
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-circle"></i>
            Hari ini kamu <strong>tidak memiliki jadwal shift</strong>.
        </div>
    @else

    {{-- Card Jadwal --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">
                <i class="fas fa-clock"></i> Jadwal Shift Hari Ini
            </h5>

            <table class="table table-borderless mb-0">
                <tr>
                    <th width="200">Nama Shift</th>
                    <td>{{ $jadwal->shift->nama_shift }}</td>
                </tr>
                <tr>
                    <th>Jam Kerja</th>
                    <td>
                        {{ $jadwal->shift->jam_mulai }}
                        -
                        {{ $jadwal->shift->jam_selesai }}
                    </td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>{{ \Carbon\Carbon::now()->format('d M Y') }}</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- Card Absensi --}}
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">
                <i class="fas fa-user-check"></i> Status Absensi
            </h5>

            {{-- Belum absen --}}
            @if(!$absensi)
                <form action="{{ route('absensi.masuk') }}" method="POST">
                    @csrf
                    <button class="btn btn-success btn-lg">
                        <i class="fas fa-sign-in-alt"></i> Absen Masuk
                    </button>
                </form>

            {{-- Sudah absen masuk --}}
            @elseif($absensi && !$absensi->jam_keluar)
                <div class="mb-3">
                    <span class="badge badge-info p-2">
                        Jam Masuk : {{ $absensi->jam_masuk }}
                    </span>
                    <span class="badge badge-warning p-2">
                        Status : {{ $absensi->status }}
                    </span>
                </div>

                <form action="{{ route('absensi.keluar') }}" method="POST">
                    @csrf
                    <button class="btn btn-danger btn-lg">
                        <i class="fas fa-sign-out-alt"></i> Absen Pulang
                    </button>
                </form>

            {{-- Sudah lengkap --}}
            @else
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    Absensi hari ini <strong>sudah lengkap</strong>.
                </div>

                <ul class="list-group">
                    <li class="list-group-item">
                        Jam Masuk : {{ $absensi->jam_masuk }}
                    </li>
                    <li class="list-group-item">
                        Jam Pulang : {{ $absensi->jam_keluar }}
                    </li>
                    <li class="list-group-item">
                        Status : {{ $absensi->status }}
                    </li>
                </ul>
            @endif

        </div>
    </div>

    @endif

</div>
@endsection
