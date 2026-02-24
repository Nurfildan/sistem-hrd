<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Dashboard - Sistem Kepegawaian</title>

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
        
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
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
                        <div>
                            <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
                            <p class="text-muted mb-0">Selamat datang, {{ auth()->user()->name }}</p>
                        </div>                        
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
                                            <small class="text-muted">Seluruh Karyawan</small>
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

                        <!-- Total Users -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-0 shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #7b1fa2;">
                                                Total Users
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }}</div>
                                            <small class="text-muted">Admin: {{ $adminCount }} | HRD: {{ $hrdCount }}</small>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon-circle bg-soft-purple">
                                                <i class="fas fa-users-cog"></i>
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
                                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #388e3c;">
                                                Total Departemen
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalDepartemen }}</div>
                                            <small class="text-muted">{{ $totalJabatan }} Jabatan</small>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon-circle bg-soft-green">
                                                <i class="fas fa-building"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Penggajian -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-0 shadow-sm h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #00796b;">
                                                Total Penggajian
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalPenggajian, 0, ',', '.') }}</div>
                                            <small class="text-muted">Bulan Ini</small>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon-circle bg-soft-teal">
                                                <i class="fas fa-money-bill-wave"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Row -->
                    <div class="row">
                        <!-- Grafik Pertumbuhan Karyawan -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow-sm mb-4 border-0">
                                <div class="card-header py-3 bg-white d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold" style="color: #1976d2;">Pertumbuhan Karyawan (6 Bulan Terakhir)</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="pertumbuhanKaryawanChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Distribusi Role Users -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow-sm mb-4 border-0">
                                <div class="card-header py-3 bg-white d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold" style="color: #1976d2;">Distribusi Role Users</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="roleUsersChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <span class="mr-3">
                                            <i class="fas fa-circle" style="color: #c62828;"></i> Admin ({{ $adminCount }})
                                        </span>
                                        <span class="mr-3">
                                            <i class="fas fa-circle" style="color: #f57c00;"></i> HRD ({{ $hrdCount }})
                                        </span>
                                        <span class="mr-3">
                                            <i class="fas fa-circle" style="color: #1976d2;"></i> Karyawan ({{ $karyawanCount }})
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tables Row -->
                    <div class="row">
                        <!-- Ringkasan Laporan -->
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow-sm border-0">
                                <div class="card-header py-3 bg-white">
                                    <h6 class="m-0 font-weight-bold" style="color: #7b1fa2;">Ringkasan Laporan</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3 pb-3 border-bottom">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="fas fa-clock text-primary mr-2"></i>
                                                <span class="font-weight-bold">Total Absensi Hari Ini</span>
                                            </div>
                                            <span class="badge badge-primary px-3 py-2">{{ $totalAbsensiHariIni }} Data</span>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-3 border-bottom">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="fas fa-calendar-alt text-warning mr-2"></i>
                                                <span class="font-weight-bold">Cuti Pending</span>
                                            </div>
                                            <span class="badge badge-warning px-3 py-2">{{ $cutiPending }} Pengajuan</span>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-3 border-bottom">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="fas fa-money-check-alt text-success mr-2"></i>
                                                <span class="font-weight-bold">Penggajian Bulan Ini</span>
                                            </div>
                                            <span class="badge badge-success px-3 py-2">{{ $totalDataGaji }} Karyawan</span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="fas fa-exclamation-triangle text-danger mr-2"></i>
                                            <span class="font-weight-bold">Karyawan Alfa Hari Ini</span>
                                        </div>
                                        <span class="badge badge-danger px-3 py-2">{{ $alfaHariIni }} Karyawan</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Karyawan per Departemen -->
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow-sm border-0">
                                <div class="card-header py-3 bg-white">
                                    <h6 class="m-0 font-weight-bold" style="color: #388e3c;">Karyawan per Departemen</h6>
                                </div>
                                <div class="card-body">
                                    @php
                                        $colors = ['#1976d2', '#388e3c', '#f57c00', '#7b1fa2', '#00796b', '#c62828'];
                                    @endphp
                                    @forelse($karyawanPerDept as $index => $dept)
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="font-weight-bold">{{ $dept->nama_departemen }}</span>
                                            <span class="badge badge-primary px-3 py-1">{{ $dept->karyawan_count }} Orang</span>
                                        </div>
                                        <div class="progress" style="height: 10px;">
                                            @php
                                                $percentage = $totalKaryawan > 0 ? ($dept->karyawan_count / $totalKaryawan) * 100 : 0;
                                            @endphp
                                            <div class="progress-bar" style="width: {{ $percentage }}%; background-color: {{ $colors[$index % 6] }};"></div>
                                        </div>
                                    </div>
                                    @empty
                                    <p class="text-center text-muted">Belum ada data departemen</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- System Activity -->
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <div class="card shadow-sm border-0">
                                <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold" style="color: #00796b;">Aktivitas Sistem Terbaru</h6>                                    
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th class="border-0">User</th>
                                                    <th class="border-0">Aktivitas</th>
                                                    <th class="border-0">Waktu</th>
                                                    <th class="border-0">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($aktivitasTerbaru as $aktivitas)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="rounded-circle bg-soft-blue mr-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                                                <i class="fas fa-user" style="font-size: 0.8rem;"></i>
                                                            </div>
                                                            <span>{{ $aktivitas->user_name }}</span>
                                                        </div>
                                                    </td>
                                                    <td>{{ $aktivitas->description }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($aktivitas->created_at)->diffForHumans() }}</td>
                                                    <td>
                                                        <span class="badge badge-success px-3 py-1">Success</span>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted py-3">Belum ada aktivitas</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
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
        // Grafik Pertumbuhan Karyawan
        var ctx = document.getElementById("pertumbuhanKaryawanChart");
        var pertumbuhanKaryawanChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labelsBulan),
                datasets: [{
                    label: "Total Karyawan",
                    lineTension: 0.3,
                    backgroundColor: "rgba(25, 118, 210, 0.05)",
                    borderColor: "#1976d2",
                    pointRadius: 4,
                    pointBackgroundColor: "#1976d2",
                    pointBorderColor: "#fff",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "#1976d2",
                    pointHoverBorderColor: "#fff",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: @json($dataPertumbuhanKaryawan),
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

        // Grafik Role Users
        var ctx2 = document.getElementById("roleUsersChart");
        var roleUsersChart = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ["Admin", "HRD", "Karyawan"],
                datasets: [{
                    data: [{{ $adminCount }}, {{ $hrdCount }}, {{ $karyawanCount }}],
                    backgroundColor: ['#c62828', '#f57c00', '#1976d2'],
                    hoverBackgroundColor: ['#b71c1c', '#e65100', '#1565c0'],
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