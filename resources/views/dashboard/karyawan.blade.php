<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard Karyawan - Sistem Kepegawaian</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <style>
        .stat-card {
            border-radius: 10px;
            transition: transform 0.2s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
        }
        
        .bg-soft-blue {
            background-color: #e3f2fd;
            color: #1976d2;
        }
        
        .bg-soft-green {
            background-color: #e8f5e9;
            color: #388e3c;
        }
        
        .bg-soft-orange {
            background-color: #fff3e0;
            color: #f57c00;
        }
        
        .bg-soft-purple {
            background-color: #f3e5f5;
            color: #7b1fa2;
        }
        
        .bg-soft-red {
            background-color: #ffebee;
            color: #c62828;
        }
        
        .bg-soft-teal {
            background-color: #e0f2f1;
            color: #00796b;
        }
        
        .profile-card {
            border-radius: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #667eea;
            border: 4px solid rgba(255, 255, 255, 0.3);
        }
        
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }
        
        .badge-soft-success {
            background-color: #e8f5e9;
            color: #388e3c;
        }
        
        .badge-soft-warning {
            background-color: #fff3e0;
            color: #f57c00;
        }
        
        .badge-soft-danger {
            background-color: #ffebee;
            color: #c62828;
        }
        
        .badge-soft-info {
            background-color: #e3f2fd;
            color: #1976d2;
        }
        
        .timeline {
            position: relative;
            padding-left: 30px;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 8px;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: #e0e0e0;
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 20px;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -26px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #1976d2;
            border: 2px solid white;
            box-shadow: 0 0 0 2px #1976d2;
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        @include('layouts.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('layouts.topbar')

                <div class="container-fluid">
                    <!-- Page Heading & Profile Card -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card profile-card border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="profile-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <h3 class="mb-1">Selamat Datang, {{ $karyawan->nama }}!</h3>
                                            <p class="mb-2 opacity-75">{{ $karyawan->jabatan->nama_jabatan ?? 'N/A' }} - {{ $karyawan->departemen->nama_departemen ?? 'N/A' }}</p>
                                            <div class="d-flex align-items-center">
                                                <span class="badge badge-light px-3 py-2 mr-2">
                                                    <i class="fas fa-id-badge mr-1"></i> {{ $karyawan->nip }}
                                                </span>
                                                <span class="badge badge-light px-3 py-2">
                                                    <i class="fas fa-briefcase mr-1"></i> {{ $karyawan->status }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-auto d-none d-md-block">
                                            <div class="text-right">
                                                <p class="mb-1 opacity-75">Hari ini</p>
                                                <h4 class="mb-0">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Cards Row -->
                    <div class="row">
                        <!-- Kehadiran Bulan Ini -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-0 shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #388e3c;">
                                                Kehadiran Bulan Ini
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $hadirBulanIni }} Hari</div>
                                            <small class="text-muted">dari {{ $totalHariKerja }} hari kerja</small>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon-circle bg-soft-green">
                                                <i class="fas fa-calendar-check"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sisa Cuti -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-0 shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #f57c00;">
                                                Sisa Cuti
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sisaCuti }} Hari</div>
                                            <small class="text-muted">dari 12 hari/tahun</small>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon-circle bg-soft-orange">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Cuti Diajukan -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-0 shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #1976d2;">
                                                Pengajuan Cuti
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $cutiSaya }}</div>
                                            <small class="text-muted">Total pengajuan</small>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon-circle bg-soft-blue">
                                                <i class="fas fa-file-signature"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gaji Bulan Ini -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-0 shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #00796b;">
                                                Gaji Terakhir
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                @if($gajiTerakhir)
                                                    Rp {{ number_format($gajiTerakhir->total_gaji, 0, ',', '.') }}
                                                @else
                                                    Rp 0
                                                @endif
                                            </div>
                                            <small class="text-muted">
                                                @if($gajiTerakhir)
                                                    {{ \Carbon\Carbon::createFromFormat('Y-m', $gajiTerakhir->periode)->locale('id')->isoFormat('MMMM Y') }}
                                                @else
                                                    Belum ada data
                                                @endif
                                            </small>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon-circle bg-soft-teal">
                                                <i class="fas fa-wallet"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Row -->
                    <div class="row">
                        <!-- Grafik Kehadiran Bulanan -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow-sm mb-4 border-0">
                                <div class="card-header py-3 bg-white d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold" style="color: #1976d2;">Riwayat Kehadiran (6 Bulan Terakhir)</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="kehadiranChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Absensi Bulan Ini -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow-sm mb-4 border-0">
                                <div class="card-header py-3 bg-white d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold" style="color: #1976d2;">Status Absensi Bulan Ini</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="statusAbsensiChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <span class="mr-3">
                                            <i class="fas fa-circle" style="color: #388e3c;"></i> Hadir ({{ $statusAbsensi['Hadir'] }})
                                        </span>
                                        <span class="mr-3">
                                            <i class="fas fa-circle" style="color: #1976d2;"></i> Izin ({{ $statusAbsensi['Izin'] }})
                                        </span>
                                        <span class="mr-3">
                                            <i class="fas fa-circle" style="color: #f57c00;"></i> Sakit ({{ $statusAbsensi['Sakit'] }})
                                        </span>
                                        <span class="mr-3">
                                            <i class="fas fa-circle" style="color: #c62828;"></i> Alfa ({{ $statusAbsensi['Alfa'] }})
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tables Row -->
                    <div class="row">
                        <!-- Riwayat Cuti -->
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow-sm border-0">
                                <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold" style="color: #f57c00;">Riwayat Pengajuan Cuti</h6>
                                    <a href="{{ route('cuti.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th class="border-0">Tanggal</th>
                                                    <th class="border-0">Keterangan</th>
                                                    <th class="border-0">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($riwayatCuti as $cuti)
                                                <tr>
                                                    <td>
                                                        <small>{{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d M Y') }}</small>
                                                        <small class="d-block text-muted">{{ $cuti->jumlah_hari }} hari</small>
                                                    </td>
                                                    <td>
                                                        <span class="d-block">{{ Str::limit($cuti->keterangan, 30) }}</span>
                                                        <small class="text-muted">{{ $cuti->jenis_cuti }}</small>
                                                    </td>
                                                    <td>
                                                        @if($cuti->status == 'Menunggu')
                                                            <span class="badge badge-soft-warning px-3 py-1">Menunggu</span>
                                                        @elseif($cuti->status == 'Disetujui')
                                                            <span class="badge badge-soft-success px-3 py-1">Disetujui</span>
                                                        @else
                                                            <span class="badge badge-soft-danger px-3 py-1">Ditolak</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="3" class="text-center text-muted py-3">Belum ada pengajuan cuti</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Riwayat Absensi Terakhir -->
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow-sm border-0">
                                <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold" style="color: #388e3c;">Riwayat Absensi Terakhir</h6>
                                    <a href="{{ route('absensi.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                                </div>
                                <div class="card-body">
                                    <div class="timeline">
                                        @forelse($riwayatAbsensi as $absensi)
                                        <div class="timeline-item">
                                            <div class="d-flex justify-content-between align-items-start mb-1">
                                                <div>
                                                    <span class="font-weight-bold">{{ \Carbon\Carbon::parse($absensi->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
                                                    @if($absensi->status == 'Hadir')
                                                        <span class="badge badge-soft-success ml-2">{{ $absensi->status }}</span>
                                                    @elseif($absensi->status == 'Izin')
                                                        <span class="badge badge-soft-info ml-2">{{ $absensi->status }}</span>
                                                    @elseif($absensi->status == 'Sakit')
                                                        <span class="badge badge-soft-warning ml-2">{{ $absensi->status }}</span>
                                                    @else
                                                        <span class="badge badge-soft-danger ml-2">{{ $absensi->status }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="text-muted small">
                                                @if($absensi->jam_masuk)
                                                    <i class="fas fa-sign-in-alt mr-1"></i> Masuk: {{ \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i') }}
                                                @endif
                                                @if($absensi->jam_keluar)
                                                    <i class="fas fa-sign-out-alt ml-3 mr-1"></i> Keluar: {{ \Carbon\Carbon::parse($absensi->jam_keluar)->format('H:i') }}
                                                @endif
                                            </div>
                                            @if($absensi->keterangan)
                                                <div class="text-muted small mt-1">
                                                    <i class="fas fa-comment mr-1"></i> {{ $absensi->keterangan }}
                                                </div>
                                            @endif
                                        </div>
                                        @empty
                                        <p class="text-center text-muted">Belum ada data absensi</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <div class="card shadow-sm border-0">
                                <div class="card-header py-3 bg-white">
                                    <h6 class="m-0 font-weight-bold" style="color: #7b1fa2;">Quick Actions</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <a href="{{ route('absensi.index') }}" class="btn btn-success btn-block py-3">
                                                <i class="fas fa-clock fa-2x mb-2"></i>
                                                <p class="mb-0">Absensi</p>
                                            </a>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <a href="{{ route('cuti.create') }}" class="btn btn-warning btn-block py-3">
                                                <i class="fas fa-calendar-plus fa-2x mb-2"></i>
                                                <p class="mb-0">Ajukan Cuti</p>
                                            </a>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <a href="{{ route('profile.index') }}" class="btn btn-info btn-block py-3">
                                                <i class="fas fa-user fa-2x mb-2"></i>
                                                <p class="mb-0">Profil Saya</p>
                                            </a>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <a href="#" class="btn btn-primary btn-block py-3">
                                                <i class="fas fa-file-invoice fa-2x mb-2"></i>
                                                <p class="mb-0">Slip Gaji</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            @include('layouts.footer')
        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>

    <script>
        // Grafik Kehadiran Bulanan
        var ctx = document.getElementById("kehadiranChart");
        var kehadiranChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($labelsBulan),
                datasets: [{
                    label: "Hari Hadir",
                    backgroundColor: "#388e3c",
                    hoverBackgroundColor: "#2e7d32",
                    borderColor: "#388e3c",
                    data: @json($dataKehadiran),
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 6
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                }
            }
        });

        // Grafik Status Absensi
        var ctx2 = document.getElementById("statusAbsensiChart");
        var statusAbsensiChart = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ["Hadir", "Izin", "Sakit", "Alfa"],
                datasets: [{
                    data: [
                        {{ $statusAbsensi['Hadir'] }}, 
                        {{ $statusAbsensi['Izin'] }}, 
                        {{ $statusAbsensi['Sakit'] }}, 
                        {{ $statusAbsensi['Alfa'] }}
                    ],
                    backgroundColor: ['#388e3c', '#1976d2', '#f57c00', '#c62828'],
                    hoverBackgroundColor: ['#2e7d32', '#1565c0', '#e65100', '#b71c1c'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: false
                },
                cutoutPercentage: 70,
            },
        });
    </script>
</body>

</html>