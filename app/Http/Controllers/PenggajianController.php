<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Penggajian;
use App\Models\Absensi;
use App\Models\AturanPotonganJabatan;
use Carbon\Carbon;
use DB;

class PenggajianController extends Controller
{
    /**
     * INDEX → tampil berdasarkan periode
     */
    public function index(Request $request)
    {
        $periode = $request->get('periode', now()->format('Y-m'));

        $penggajian = Penggajian::with('karyawan.jabatan')
            ->where('periode', $periode)
            ->orderBy('karyawan_id')
            ->get();

        return view('penggajian.index', compact('penggajian', 'periode'));
    }

    /**
     * GENERATE GAJI BULANAN (1 tombol)
     */
    public function generateBulanan(Request $request)
    {
        $request->validate([
            'periode' => 'required|date_format:Y-m'
        ]);

        $periode = $request->periode;
        $bulan = Carbon::createFromFormat('Y-m', $periode)->month;
        $tahun = Carbon::createFromFormat('Y-m', $periode)->year;

        DB::transaction(function () use ($periode, $bulan, $tahun) {

            $karyawans = Karyawan::with('jabatan')->get();

            foreach ($karyawans as $karyawan) {

                $aturan = AturanPotonganJabatan::where('jabatan_id', $karyawan->jabatan_id)->first();
                if (!$aturan) continue;

                $absensis = Absensi::where('karyawan_id', $karyawan->id)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->get();

                $potonganOtomatis = 0;

                foreach ($absensis as $absen) {
                    $potonganOtomatis += match ($absen->status) {
                        'Hadir' => $aturan->potongan_hadir,
                        'Terlambat' => $aturan->potongan_terlambat,
                        'Izin' => $aturan->potongan_izin,
                        'Sakit' => $aturan->potongan_sakit,
                        'Alpa' => $aturan->potongan_alpa,
                        'Cuti' => $aturan->potongan_cuti,
                        default => 0
                    };
                }

                $gajiPokok = $karyawan->jabatan->gaji_pokok;
                $tunjangan = $karyawan->jabatan->tunjangan;

                Penggajian::updateOrCreate(
                    [
                        'karyawan_id' => $karyawan->id,
                        'periode' => $periode
                    ],
                    [
                        'tanggal_penggajian' => now(),
                        'gaji_pokok' => $gajiPokok,
                        'tunjangan' => $tunjangan,
                        'potongan_otomatis' => $potonganOtomatis,
                        'potongan_tambahan' => 0,
                        'total_gaji' => ($gajiPokok + $tunjangan) - $potonganOtomatis,
                        'status_pembayaran' => 'Belum Dibayar'
                    ]
                );
            }
        });

        return redirect()
            ->route('penggajian.index', ['periode' => $periode])
            ->with('success', 'Penggajian berhasil digenerate');
    }

    /**
     * DETAIL GAJI (1 karyawan, 1 bulan)
     */
    public function show($id)
    {
        $penggajian = Penggajian::with(['karyawan.jabatan', 'potongan'])->findOrFail($id);
        return view('penggajian.show', compact('penggajian'));
    }
}
