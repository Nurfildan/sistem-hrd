<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Potongan;
use App\Models\Penggajian;

class PotonganController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'penggajian_id' => 'required|exists:penggajian,id',
        'nama_potongan' => 'required|string',
        'jumlah' => 'required|numeric|min:0',
    ]);

    Potongan::create($request->all());

    $penggajian = Penggajian::findOrFail($request->penggajian_id);

    $totalTambahan = $penggajian->potongan()->sum('jumlah');

    $penggajian->update([
        'potongan_tambahan' => $totalTambahan,
        'total_gaji' => ($penggajian->gaji_pokok + $penggajian->tunjangan)
                        - $penggajian->potongan_otomatis
                        - $totalTambahan
    ]);

    return back()->with('success', 'Potongan tambahan berhasil ditambahkan');
}

}
