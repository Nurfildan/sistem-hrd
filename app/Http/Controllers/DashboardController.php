<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Karyawan;
use App\Models\Absensi;
use App\Models\Cuti;
use App\Models\Penggajian;
use App\Models\Departemen;
use App\Models\Jabatan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ADMIN DASHBOARD
        if ($user->role === 'Admin') {
            return $this->adminDashboard();
        }

        // HRD DASHBOARD
        if ($user->role === 'HRD') {
            return $this->hrdDashboard();
        }

        // KARYAWAN DASHBOARD
        if ($user->role === 'Karyawan') {
            return $this->karyawanDashboard();
        }

        abort(403);
    }

    /**
     * Dashboard untuk Admin
     */
    private function adminDashboard()
    {
        // Total Statistics
        $totalKaryawan = Karyawan::count();
        $totalUsers = User::count();
        $adminCount = User::where('role', 'Admin')->count();
        $hrdCount = User::where('role', 'HRD')->count();
        $karyawanCount = User::where('role', 'Karyawan')->count();
        $totalDepartemen = Departemen::count();
        $totalJabatan = Jabatan::count();

        // Menggunakan periode format YYYY-MM (sesuai dengan kolom 'periode' di tabel)
        $periodeBulanIni = Carbon::now()->format('Y-m');
        $totalPenggajian = Penggajian::where('periode', $periodeBulanIni)
            ->sum('total_gaji');

        // Data untuk Grafik Pertumbuhan Karyawan (6 bulan terakhir)
        $labelsBulan = [];
        $dataPertumbuhanKaryawan = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labelsBulan[] = $date->locale('id')->isoFormat('MMM Y');
            $dataPertumbuhanKaryawan[] = Karyawan::whereDate('tgl_masuk', '<=', $date->endOfMonth())->count();
        }

        // Karyawan per Departemen
        $karyawanPerDept = Departemen::withCount('karyawan')
            ->orderBy('karyawan_count', 'desc')
            ->limit(6)
            ->get();

        // Summary Reports
        $totalAbsensiHariIni = Absensi::whereDate('tanggal', Carbon::today())->count();
        $cutiPending = Cuti::where('status', 'Menunggu')->count();

        // Perbaikan query untuk penggajian
        $totalDataGaji = Penggajian::where('periode', $periodeBulanIni)->count();

        $alfaHariIni = Absensi::whereDate('tanggal', Carbon::today())
            ->where('status', 'Alfa')
            ->count();

        // Aktivitas Sistem Terbaru (simulasi - sesuaikan dengan model log Anda jika ada)
        $aktivitasTerbaru = collect([
            (object) [
                'user_name' => 'Admin',
                'description' => 'Menambahkan karyawan baru',
                'created_at' => Carbon::now()->subHours(2),
            ],
            (object) [
                'user_name' => 'HRD',
                'description' => 'Menyetujui pengajuan cuti',
                'created_at' => Carbon::now()->subHours(3),
            ],
            (object) [
                'user_name' => 'Admin',
                'description' => 'Update data departemen',
                'created_at' => Carbon::now()->subHours(5),
            ],
        ]);

        return view('dashboard.admin', compact(
            'totalKaryawan',
            'totalUsers',
            'adminCount',
            'hrdCount',
            'karyawanCount',
            'totalDepartemen',
            'totalJabatan',
            'totalPenggajian',
            'labelsBulan',
            'dataPertumbuhanKaryawan',
            'karyawanPerDept',
            'totalAbsensiHariIni',
            'cutiPending',
            'totalDataGaji',
            'alfaHariIni',
            'aktivitasTerbaru'
        ));
    }

    /**
     * Dashboard untuk HRD
     */
    private function hrdDashboard()
    {
        // Total Statistics
        $karyawanAktif = Karyawan::count();
        $absensiHariIni = Absensi::whereDate('tanggal', Carbon::today())
            ->where('status', 'Hadir')
            ->count();
        $cutiMenunggu = Cuti::where('status', 'Menunggu')->count();

        // Menggunakan periode format YYYY-MM
        $periodeBulanIni = Carbon::now()->format('Y-m');
        $totalGajiDiproses = Penggajian::where('periode', $periodeBulanIni)->count();

        // Data untuk Grafik Absensi Mingguan (7 hari terakhir)
        $labels = [];
        $absensiMingguan = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->locale('id')->isoFormat('ddd, D MMM');
            $absensiMingguan[] = Absensi::whereDate('tanggal', $date)
                ->where('status', 'Hadir')
                ->count();
        }

        // Status Karyawan
        $statusKaryawan = [
            'Tetap' => Karyawan::where('status', 'Tetap')->count(),
            'Kontrak' => Karyawan::where('status', 'Kontrak')->count(),
            'Magang' => Karyawan::where('status', 'Magang')->count(),
        ];

        // Pengajuan Cuti Terbaru
        $cutiTerbaru = Cuti::with(['karyawan.departemen'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Karyawan per Departemen
        $karyawanPerDept = Departemen::withCount('karyawan')
            ->orderBy('karyawan_count', 'desc')
            ->limit(5)
            ->get();

        // Ringkasan Penggajian - disesuaikan dengan struktur tabel
        $ringkasanGaji = [
            'gaji_pokok' => Penggajian::where('periode', $periodeBulanIni)->sum('gaji_pokok'),
            'tunjangan' => Penggajian::where('periode', $periodeBulanIni)->sum('tunjangan'),
            'potongan' => Penggajian::where('periode', $periodeBulanIni)
                ->with('potongan')
                ->get()
                ->sum(function ($item) {
                    return $item->potongan_otomatis + $item->potongan->sum('jumlah');
                }),
            'net_payroll' => Penggajian::where('periode', $periodeBulanIni)->sum('total_gaji'),
        ];

        return view('dashboard.hrd', compact(
            'karyawanAktif',
            'absensiHariIni',
            'cutiMenunggu',
            'totalGajiDiproses',
            'labels',
            'absensiMingguan',
            'statusKaryawan',
            'cutiTerbaru',
            'karyawanPerDept',
            'ringkasanGaji'
        ));
    }

    /**
     * Dashboard untuk Karyawan
     */
    private function karyawanDashboard()
    {
        $user = Auth::user();
        $karyawan = $user->karyawan;

        if (!$karyawan) {
            abort(404, 'Data karyawan tidak ditemukan');
        }

        // Total Statistics
        $hadirBulanIni = Absensi::where('karyawan_id', $karyawan->id)
            ->whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->where('status', 'Hadir')
            ->count();

        $totalHariKerja = Carbon::now()->diffInDaysFiltered(function (Carbon $date) {
            return $date->isWeekday();
        }, Carbon::now()->startOfMonth());

        // Hitung sisa cuti (asumsi: 12 hari per tahun)
        $cutiTerpakai = Cuti::where('karyawan_id', $karyawan->id)
            ->where('status', 'Disetujui')
            ->whereYear('tanggal_mulai', Carbon::now()->year)
            ->select(DB::raw('SUM(DATEDIFF(tanggal_selesai, tanggal_mulai) + 1) as total'))
            ->value('total') ?? 0;
        $sisaCuti = 12 - $cutiTerpakai;

        $cutiSaya = Cuti::where('karyawan_id', $karyawan->id)->count();

        // Gaji Terakhir - disesuaikan dengan struktur tabel
        $gajiTerakhir = Penggajian::where('karyawan_id', $karyawan->id)
            ->orderBy('periode', 'desc')
            ->first();

        // Data untuk Grafik Kehadiran (6 bulan terakhir)
        $labelsBulan = [];
        $dataKehadiran = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labelsBulan[] = $date->locale('id')->isoFormat('MMM Y');
            $dataKehadiran[] = Absensi::where('karyawan_id', $karyawan->id)
                ->whereMonth('tanggal', $date->month)
                ->whereYear('tanggal', $date->year)
                ->where('status', 'Hadir')
                ->count();
        }

        // Status Absensi Bulan Ini
        $statusAbsensi = [
            'Hadir' => Absensi::where('karyawan_id', $karyawan->id)
                ->whereMonth('tanggal', Carbon::now()->month)
                ->whereYear('tanggal', Carbon::now()->year)
                ->where('status', 'Hadir')
                ->count(),
            'Izin' => Absensi::where('karyawan_id', $karyawan->id)
                ->whereMonth('tanggal', Carbon::now()->month)
                ->whereYear('tanggal', Carbon::now()->year)
                ->where('status', 'Izin')
                ->count(),
            'Sakit' => Absensi::where('karyawan_id', $karyawan->id)
                ->whereMonth('tanggal', Carbon::now()->month)
                ->whereYear('tanggal', Carbon::now()->year)
                ->where('status', 'Sakit')
                ->count(),
            'Alfa' => Absensi::where('karyawan_id', $karyawan->id)
                ->whereMonth('tanggal', Carbon::now()->month)
                ->whereYear('tanggal', Carbon::now()->year)
                ->where('status', 'Alfa')
                ->count(),
        ];

        // Riwayat Cuti
        $riwayatCuti = Cuti::where('karyawan_id', $karyawan->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Riwayat Absensi Terakhir
        $riwayatAbsensi = Absensi::where('karyawan_id', $karyawan->id)
            ->orderBy('tanggal', 'desc')
            ->limit(7)
            ->get();

        return view('dashboard.karyawan', compact(
            'karyawan',
            'hadirBulanIni',
            'totalHariKerja',
            'sisaCuti',
            'cutiSaya',
            'gajiTerakhir',
            'labelsBulan',
            'dataKehadiran',
            'statusAbsensi',
            'riwayatCuti',
            'riwayatAbsensi'
        ));
    }
}