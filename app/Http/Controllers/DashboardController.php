<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Cuti;
use App\Models\Departemen;
use App\Models\Absensi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display dashboard with statistics
     */
    public function index()
    {
        try {
            // Total Karyawan Aktif
            $totalKaryawan = Karyawan::count();

            // Kehadiran hari ini
            $today = Carbon::today();
            $hadirHariIni = Absensi::whereDate('tanggal', $today)
                ->whereIn('status', ['Hadir', 'Terlambat'])
                ->count();

            // Cuti menunggu persetujuan
            $cutiMenunggu = Cuti::where('status', 'Menunggu')->count();

            // Total Departemen
            $totalDepartemen = Departemen::count();

            // Data absensi mingguan (7 hari terakhir)
            $absensiMingguan = [];
            $labels = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::today()->subDays($i);
                $count = Absensi::whereDate('tanggal', $date)
                    ->whereIn('status', ['Hadir', 'Terlambat'])
                    ->count();
                $absensiMingguan[] = $count;

                // Label hari dalam bahasa Indonesia
                $dayNames = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
                $labels[] = $dayNames[$date->dayOfWeek];
            }

            // Status karyawan untuk pie chart
            $statusKaryawan = [
                'Tetap' => Karyawan::where('status', 'Tetap')->count(),
                'Kontrak' => Karyawan::where('status', 'Kontrak')->count(),
                'Magang' => Karyawan::where('status', 'Magang')->count(),
            ];

            // 5 Pengajuan cuti terbaru
            $cutiTerbaru = Cuti::with('karyawan')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            // Karyawan per departemen (top 5)
            $karyawanPerDept = Departemen::withCount('karyawan')
                ->orderBy('karyawan_count', 'desc')
                ->take(5)
                ->get();

            // Hitung total karyawan dari semua departemen untuk persentase
            $totalKaryawanDept = $karyawanPerDept->sum('karyawan_count');
            if ($totalKaryawanDept == 0) {
                $totalKaryawanDept = 1; // Hindari division by zero
            }

            // Ringkasan penggajian
            $totalGajiPokok = 0;

            // Cek apakah kolom gaji_pokok ada di tabel karyawan
            if (DB::getSchemaBuilder()->hasColumn('karyawan', 'gaji_pokok')) {
                $totalGajiPokok = Karyawan::sum('gaji_pokok') ?? 0;
            } else {
                // Jika kolom tidak ada, gunakan nilai default
                $totalGajiPokok = 150000000;
            }

            $ringkasanGaji = [
                'gaji_pokok' => $totalGajiPokok,
                'tunjangan' => $totalGajiPokok * 0.3, // 30% dari gaji pokok
                'potongan' => $totalGajiPokok * 0.1, // 10% dari gaji pokok
            ];
            $ringkasanGaji['net_payroll'] = $ringkasanGaji['gaji_pokok'] +
                $ringkasanGaji['tunjangan'] -
                $ringkasanGaji['potongan'];

            return view('dashboard', compact(
                'totalKaryawan',
                'hadirHariIni',
                'cutiMenunggu',
                'totalDepartemen',
                'absensiMingguan',
                'labels',
                'statusKaryawan',
                'cutiTerbaru',
                'karyawanPerDept',
                'totalKaryawanDept',
                'ringkasanGaji'
            ));

        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Dashboard Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            // Return view dengan data default jika error
            return view('dashboard', [
                'totalKaryawan' => 0,
                'hadirHariIni' => 0,
                'cutiMenunggu' => 0,
                'totalDepartemen' => 0,
                'absensiMingguan' => [0, 0, 0, 0, 0, 0, 0],
                'labels' => ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                'statusKaryawan' => ['Tetap' => 0, 'Kontrak' => 0, 'Magang' => 0],
                'cutiTerbaru' => collect([]),
                'karyawanPerDept' => collect([]),
                'totalKaryawanDept' => 1,
                'ringkasanGaji' => [
                    'gaji_pokok' => 0,
                    'tunjangan' => 0,
                    'potongan' => 0,
                    'net_payroll' => 0
                ]
            ]);
        }
    }
}