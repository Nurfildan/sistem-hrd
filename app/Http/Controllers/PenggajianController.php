<?php

namespace App\Http\Controllers;

use App\Models\Penggajian;
use App\Models\Karyawan;
use App\Models\Absensi;
use App\Models\AturanPotonganJabatan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PenggajianController extends Controller
{
    /**
     * List penggajian
     * HRD: semua
     */
    public function index(Request $request)
    {
        // Default periode = bulan sekarang
        $periode = $request->periode ?? now()->format('Y-m');

        $penggajian = Penggajian::with('karyawan')
            ->where('periode', $periode)
            ->orderBy('periode', 'desc')
            ->get();

        return view('penggajian.index', compact('penggajian', 'periode'));
    }


    /**
     * Generate gaji bulanan
     * (HRD only)
     */
    public function generateBulanan(Request $request)
    {
        $request->validate([
            'periode' => 'required', // contoh: 2026-02
        ]);

        $periode = $request->periode;
        $tanggalGaji = Carbon::now()->toDateString();

        $karyawanList = Karyawan::with('jabatan')->get();

        foreach ($karyawanList as $karyawan) {

            // Cegah double generate
            $exists = Penggajian::where('karyawan_id', $karyawan->id)
                ->where('periode', $periode)
                ->first();

            if ($exists) {
                continue;
            }

            // ===== Gaji dasar =====
            $gajiPokok = $karyawan->jabatan->gaji_pokok ?? 0;
            $tunjangan = $karyawan->jabatan->tunjangan ?? 0;

            // ===== Hitung potongan otomatis dari absensi =====
            $potonganOtomatis = $this->hitungPotonganAbsensi($karyawan, $periode);

            $totalGaji = ($gajiPokok + $tunjangan) - $potonganOtomatis;

            Penggajian::create([
                'karyawan_id' => $karyawan->id,
                'periode' => $periode,
                'tanggal_penggajian' => $tanggalGaji,
                'gaji_pokok' => $gajiPokok,
                'tunjangan' => $tunjangan,
                'potongan_otomatis' => $potonganOtomatis,
                'potongan_tambahan' => 0,
                'total_gaji' => $totalGaji,
                'status_pembayaran' => 'Belum Dibayar',
            ]);
        }

        return back()->with('success', 'Penggajian berhasil digenerate.');
    }

    /**
     * Detail penggajian
     */
    public function show($id)
    {
        $penggajian = Penggajian::with([
            'karyawan.jabatan',
            'potongan'
        ])->findOrFail($id);

        return view('penggajian.show', compact('penggajian'));
    }

    /**
     * Hitung potongan otomatis berdasarkan absensi
     */
    private function hitungPotonganAbsensi($karyawan, $periode)
    {
        [$tahun, $bulan] = explode('-', $periode);

        $absensi = Absensi::where('karyawan_id', $karyawan->id)
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->get();

        $aturan = AturanPotonganJabatan::where('jabatan_id', $karyawan->jabatan_id)->first();

        if (!$aturan) {
            return 0;
        }

        $total = 0;

        foreach ($absensi as $a) {
            switch ($a->status) {
                case 'Terlambat':
                    $total += $aturan->potongan_terlambat;
                    break;
                case 'Izin':
                    $total += $aturan->potongan_izin;
                    break;
                case 'Sakit':
                    $total += $aturan->potongan_sakit;
                    break;
                case 'Alpa':
                    $total += $aturan->potongan_alpa;
                    break;
                case 'Cuti':
                    $total += $aturan->potongan_cuti;
                    break;
            }
        }

        return $total;
    }
}
