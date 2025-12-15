<?php

namespace App\Http\Controllers;

use App\Models\Penggajian;
use App\Models\Karyawan;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PenggajianController extends Controller
{
    public function index()
    {
        $penggajian = Penggajian::with('karyawan')
            ->orderByDesc('tanggal_penggajian')
            ->get();

        return view('penggajian.index', compact('penggajian'));
    }

    public function create()
    {
        $karyawan = Karyawan::with('jabatan')->get();
        return view('penggajian.create', compact('karyawan'));
    }

    public function show($id)
    {
        $penggajian = Penggajian::with([
            'karyawan.jabatan',
            'potongan'
        ])->findOrFail($id);

        return view('penggajian.show', compact('penggajian'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
            'bulan' => 'required', // format: YYYY-MM
        ]);

        $karyawan = Karyawan::with('jabatan')->findOrFail($request->karyawan_id);

        $gaji_pokok = $karyawan->jabatan->gaji_pokok;
        $tunjangan = $karyawan->jabatan->tunjangan;

        // =========================
        // POTONGAN (sementara 0)
        // =========================
        $potongan_otomatis = 0;
        $potongan_tambahan = 0;

        $total = $gaji_pokok + $tunjangan - ($potongan_otomatis + $potongan_tambahan);

        Penggajian::create([
            'karyawan_id' => $karyawan->id,
            'periode' => $request->bulan, // 🔴 INI YANG HILANG
            'tanggal_penggajian' => now(),
            'gaji_pokok' => $gaji_pokok,
            'tunjangan' => $tunjangan,
            'potongan_otomatis' => $potongan_otomatis,
            'potongan_tambahan' => $potongan_tambahan,
            'total_gaji' => $total,
            'status_pembayaran' => 'Belum Dibayar'
        ]);

        return redirect()
            ->route('penggajian.index')
            ->with('success', 'Penggajian berhasil digenerate');
    }


    public function hitung(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
            'periode' => 'required'
        ]);

        $karyawan = Karyawan::with('jabatan.aturanPotongan')
            ->findOrFail($request->karyawan_id);

        [$tahun, $bulan] = explode('-', $request->periode);

        $alpa = Absensi::where('karyawan_id', $karyawan->id)
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->where('status', 'Tidak Hadir')
            ->count();

        $potonganPerHari = $karyawan->jabatan->aturanPotongan->potongan_per_hari ?? 0;

        $potongan_otomatis = $alpa * $potonganPerHari;

        $gaji_pokok = $karyawan->jabatan->gaji_pokok;
        $tunjangan = $karyawan->jabatan->tunjangan;

        $total = $gaji_pokok + $tunjangan - $potongan_otomatis;

        return response()->json([
            'gaji_pokok' => $gaji_pokok,
            'tunjangan' => $tunjangan,
            'potongan_otomatis' => $potongan_otomatis,
            'total_gaji' => $total
        ]);
    }
}
