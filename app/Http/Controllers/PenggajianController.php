<?php

namespace App\Http\Controllers;

use App\Models\Penggajian;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class PenggajianController extends Controller
{
    public function index()
    {
        $penggajian = Penggajian::with('karyawan')->get();
        return view('penggajian.index', compact('penggajian'));
    } 

    public function create()
    {
        $karyawan = Karyawan::with('jabatan')->get();
        return view('penggajian.create', compact('karyawan'));
    }

    public function show($id)
    {
        // Ambil data penggajian dengan relasi karyawan & jabatan
        $penggajian = Penggajian::with(['karyawan.jabatan'])
            ->findOrFail($id);

        return view('penggajian.show', compact('penggajian'));
    }


    public function store(Request $request)
    {
        $karyawan = Karyawan::findOrFail($request->karyawan_id);
        $gaji_pokok = $karyawan->jabatan->gaji_pokok;
        $tunjangan = $karyawan->jabatan->tunjangan;
        $potongan = 0;

        $total = $gaji_pokok + $tunjangan - $potongan;

        Penggajian::create([
            'karyawan_id' => $karyawan->id,
            'bulan' => $request->bulan,
            'tanggal_penggajian' => now(),
            'gaji_pokok' => $gaji_pokok,
            'tunjangan' => $tunjangan,
            'potongan' => $potongan,
            'total_gaji' => $total,
            'status_pembayaran' => 'Belum Dibayar'
        ]);

        return redirect()->route('penggajian.index')->with('success', 'Data gaji berhasil ditambahkan.');
    }


    //     public function store(Request $request)
// {
//     $karyawan = Karyawan::with('jabatan')->findOrFail($request->karyawan_id);

    //     $gaji_pokok = $karyawan->jabatan->gaji_pokok;
//     $tunjangan  = $karyawan->jabatan->tunjangan;

    //     // ==============================
//     // HITUNG POTONGAN AUTOMATIS
//     // ==============================

    //     $absensi = \App\Models\Absensi::where('karyawan_id', $karyawan->id)
//         ->whereMonth('tanggal', date('m', strtotime($request->bulan)))
//         ->whereYear('tanggal', date('Y', strtotime($request->bulan)))
//         ->get();

    //     $potongan = 0;
//     $tarif_potongan_per_jam = 15000; // bisa diubah

    //     foreach ($absensi as $a) {

    //         // 1. Jika tidak hadir
//         if ($a->status == 'Tidak Hadir') {
//             $potongan += 50000; // aturan bebas
//             continue;
//         }

    //         // 2. Jika jam masuk & keluar tercatat → hitung jam kerja
//         if ($a->jam_masuk && $a->jam_keluar) {
//             $jamKerja = \Carbon\Carbon::parse($a->jam_masuk)
//                         ->diffInHours(\Carbon\Carbon::parse($a->jam_keluar));

    //             if ($jamKerja < 8) {
//                 $kurang = 8 - $jamKerja;
//                 $potongan += $kurang * $tarif_potongan_per_jam;
//             }
//         }
//     }

    //     // ==============================
//     // TOTAL GAJI
//     // ==============================
//     $total = $gaji_pokok + $tunjangan - $potongan;

    //     // SIMPAN
//     Penggajian::create([
//         'karyawan_id' => $karyawan->id,
//         'bulan' => $request->bulan,
//         'tanggal_penggajian' => now(),
//         'gaji_pokok' => $gaji_pokok,
//         'tunjangan' => $tunjangan,
//         'potongan' => $potongan,
//         'total_gaji' => $total,
//         'status_pembayaran' => 'Belum Dibayar'
//     ]);

    //     return redirect()->route('penggajian.index')->with('success', 'Data gaji berhasil ditambahkan.');
// }
}
