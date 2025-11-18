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
}
