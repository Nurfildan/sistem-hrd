<?php

namespace App\Http\Controllers;

use App\Models\Potongan;
use App\Models\Penggajian;
use Illuminate\Http\Request;

class PotonganController extends Controller
{
    /**
     * Simpan potongan manual (HRD)
     */
    public function store(Request $request)
    {
        $request->validate([
            'penggajian_id' => 'required|exists:penggajian,id',
            'nama_potongan' => 'required|string|max:255',
            'jumlah'        => 'required|numeric|min:0',
            'keterangan'    => 'nullable|string',
        ]);

        $potongan = Potongan::create([
            'penggajian_id' => $request->penggajian_id,
            'nama_potongan' => $request->nama_potongan,
            'jumlah'        => $request->jumlah,
            'keterangan'    => $request->keterangan,
        ]);

        // Update total gaji
        $this->recalculateGaji($request->penggajian_id);

        return back()->with('success', 'Potongan berhasil ditambahkan.');
    }

    /**
     * Hapus potongan
     */
    public function destroy(Potongan $potongan)
    {
        $penggajianId = $potongan->penggajian_id;
        $potongan->delete();

        // Update ulang total gaji
        $this->recalculateGaji($penggajianId);

        return back()->with('success', 'Potongan berhasil dihapus.');
    }

    /**
     * Hitung ulang total gaji
     */
    private function recalculateGaji($penggajianId)
    {
        $penggajian = Penggajian::with('potongan')->findOrFail($penggajianId);

        $totalPotonganTambahan = $penggajian->potongan->sum('jumlah');

        $penggajian->update([
            'potongan_tambahan' => $totalPotonganTambahan,
            'total_gaji' => 
                ($penggajian->gaji_pokok + $penggajian->tunjangan)
                - $penggajian->potongan_otomatis
                - $totalPotonganTambahan,
        ]);
    }
}
