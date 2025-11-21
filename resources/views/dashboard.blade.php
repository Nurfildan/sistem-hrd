<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sistem Informasi Kepegawaian - Dashboard</title>

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
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
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
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        @include('layouts.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('layouts.topbar')

                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard Kepegawaian</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            <i class="fas fa-download fa-sm text-white-50"></i> Export Laporan
                        </a>
                    </div>

                    <!-- Statistics Cards Row -->
                    <div class="row">
                        <!-- Total Karyawan -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-0 shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #1976d2;">
                                                Total Karyawan
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalKaryawan }}</div>
                                            <small class="text-muted">Karyawan Aktif</small>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon-circle bg-soft-blue">
                                                <i class="fas fa-users"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hadir Hari Ini -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-0 shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #388e3c;">
                                                Hadir Hari Ini
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $hadirHariIni }}</div>
                                            <small class="text-muted">dari {{ $totalKaryawan }} karyawan</small>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon-circle bg-soft-green">
                                                <i class="fas fa-user-check"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pengajuan Cuti -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-0 shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #f57c00;">
                                                Pengajuan Cuti
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $cutiMenunggu }}</div>
                                            <small class="text-muted">Menunggu Persetujuan</small>
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

                        <!-- Total Departemen -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-0 shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #7b1fa2;">
                                                Total Departemen
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalDepartemen }}</div>
                                            <small class="text-muted">Departemen Aktif</small>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon-circle bg-soft-purple">
                                                <i class="fas fa-building"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Row -->
                    <div class="row">
                        <!-- Grafik Absensi Mingguan -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow-sm mb-4 border-0">
                                <div class="card-header py-3 bg-white d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold" style="color: #1976d2;">Statistik Absensi Mingguan</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="absensiChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Karyawan -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow-sm mb-4 border-0">
                                <div class="card-header py-3 bg-white d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold" style="color: #1976d2;">Status Karyawan</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="statusKaryawanChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <span class="mr-3">
                                            <i class="fas fa-circle" style="color: #388e3c;"></i> Tetap ({{ $statusKaryawan['Tetap'] }})
                                        </span>
                                        <span class="mr-3">
                                            <i class="fas fa-circle" style="color: #f57c00;"></i> Kontrak ({{ $statusKaryawan['Kontrak'] }})
                                        </span>
                                        <span class="mr-3">
                                            <i class="fas fa-circle" style="color: #1976d2;"></i> Magang ({{ $statusKaryawan['Magang'] }})
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tables Row -->
                    <div class="row">
                        <!-- Pengajuan Cuti Terbaru -->
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow-sm border-0">
                                <div class="card-header py-3 bg-white">
                                    <h6 class="m-0 font-weight-bold" style="color: #f57c00;">Pengajuan Cuti Terbaru</h6>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th class="border-0">Nama</th>
                                                    <th class="border-0">Tanggal</th>
                                                    <th class="border-0">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($cutiTerbaru as $cuti)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="rounded-circle bg-soft-blue mr-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                                                <i class="fas fa-user" style="font-size: 0.8rem;"></i>
                                                            </div>
                                                            <span>{{ $cuti->karyawan->nama ?? 'N/A' }}</span>
                                                        </div>
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d M Y') }}</td>
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

                        <!-- Karyawan per Departemen -->
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow-sm border-0">
                                <div class="card-header py-3 bg-white">
                                    <h6 class="m-0 font-weight-bold" style="color: #7b1fa2;">Karyawan per Departemen</h6>
                                </div>
                                <div class="card-body">
                                    @php
                                        $colors = ['#1976d2', '#388e3c', '#f57c00', '#7b1fa2', '#00796b'];
                                    @endphp
                                    @forelse($karyawanPerDept as $index => $dept)
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="font-weight-bold">{{ $dept->nama_departemen }}</span>
                                            <span class="badge badge-soft-info px-3 py-1">{{ $dept->karyawan_count }} Orang</span>
                                        </div>
                                        <div class="progress" style="height: 8px;">
                                            @php
                                                $percentage = $totalKaryawanDept > 0 ? ($dept->karyawan_count / $totalKaryawanDept) * 100 : 0;
                                            @endphp
                                            <div class="progress-bar" style="width: {{ $percentage }}%; background-color: {{ $colors[$index % 5] }};"></div>
                                        </div>
                                    </div>
                                    @empty
                                    <p class="text-center text-muted">Belum ada data departemen</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Penggajian Summary -->
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <div class="card shadow-sm border-0">
                                <div class="card-header py-3 bg-white">
                                    <h6 class="m-0 font-weight-bold" style="color: #00796b;">Ringkasan Penggajian Bulan Ini</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <div class="p-3 text-center" style="background-color: #e0f2f1; border-radius: 8px;">
                                                <div class="text-muted small mb-1">Total Gaji Pokok</div>
                                                <h4 class="mb-0 font-weight-bold" style="color: #00796b;">Rp {{ number_format($ringkasanGaji['gaji_pokok'], 0, ',', '.') }}</h4>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="p-3 text-center" style="background-color: #e8f5e9; border-radius: 8px;">
                                                <div class="text-muted small mb-1">Total Tunjangan</div>
                                                <h4 class="mb-0 font-weight-bold" style="color: #388e3c;">Rp {{ number_format($ringkasanGaji['tunjangan'], 0, ',', '.') }}</h4>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="p-3 text-center" style="background-color: #ffebee; border-radius: 8px;">
                                                <div class="text-muted small mb-1">Total Potongan</div>
                                                <h4 class="mb-0 font-weight-bold" style="color: #c62828;">Rp {{ number_format($ringkasanGaji['potongan'], 0, ',', '.') }}</h4>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="p-3 text-center" style="background-color: #e3f2fd; border-radius: 8px;">
                                                <div class="text-muted small mb-1">Net Payroll</div>
                                                <h4 class="mb-0 font-weight-bold" style="color: #1976d2;">Rp {{ number_format($ringkasanGaji['net_payroll'], 0, ',', '.') }}</h4>
                                            </div>
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
        // Grafik Absensi Mingguan (Data Real dari Backend)
        var ctx = document.getElementById("absensiChart");
        var absensiChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: "Hadir",
                    lineTension: 0.3,
                    backgroundColor: "rgba(25, 118, 210, 0.05)",
                    borderColor: "#1976d2",
                    pointRadius: 3,
                    pointBackgroundColor: "#1976d2",
                    pointBorderColor: "#1976d2",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "#1976d2",
                    pointHoverBorderColor: "#1976d2",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: @json($absensiMingguan),
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
                            maxTicksLimit: 7
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

        // Grafik Status Karyawan (Data Real dari Backend)
        var ctx2 = document.getElementById("statusKaryawanChart");
        var statusKaryawanChart = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ["Tetap", "Kontrak", "Magang"],
                datasets: [{
                    data: [{{ $statusKaryawan['Tetap'] }}, {{ $statusKaryawan['Kontrak'] }}, {{ $statusKaryawan['Magang'] }}],
                    backgroundColor: ['#388e3c', '#f57c00', '#1976d2'],
                    hoverBackgroundColor: ['#2e7d32', '#e65100', '#1565c0'],
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