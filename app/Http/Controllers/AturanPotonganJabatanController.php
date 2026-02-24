<?php

namespace App\Http\Controllers;

use App\Models\AturanPotonganJabatan;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class AturanPotonganJabatanController extends Controller
{
    /**
     * List aturan potongan per jabatan
     */
    public function index()
    {
        $aturan = AturanPotonganJabatan::with('jabatan')->get();
        return view('aturan_potongan.index', compact('aturan'));
    }

    /**
     * Form tambah aturan
     */
    public function create()
    {
        // Ambil jabatan yang BELUM punya aturan
        $jabatan = Jabatan::whereDoesntHave('aturanPotongan')->get();

        return view('aturan_potongan.create', compact('jabatan'));
    }

    /**
     * Simpan aturan potongan
     */
    public function store(Request $request)
    {
        $request->validate([
            'jabatan_id' => 'required|exists:jabatan,id|unique:aturan_potongan_jabatan,jabatan_id',
            'potongan_hadir' => 'nullable|numeric|min:0',
            'potongan_terlambat' => 'nullable|numeric|min:0',
            'potongan_izin' => 'nullable|numeric|min:0',
            'potongan_sakit' => 'nullable|numeric|min:0',
            'potongan_alpa' => 'nullable|numeric|min:0',
            'potongan_cuti' => 'nullable|numeric|min:0',
        ]);

        AturanPotonganJabatan::create([
            'jabatan_id' => $request->jabatan_id,
            'potongan_hadir' => $request->potongan_hadir ?? 0,
            'potongan_terlambat' => $request->potongan_terlambat ?? 0,
            'potongan_izin' => $request->potongan_izin ?? 0,
            'potongan_sakit' => $request->potongan_sakit ?? 0,
            'potongan_alpa' => $request->potongan_alpa ?? 0,
            'potongan_cuti' => $request->potongan_cuti ?? 0,
        ]);

        return redirect()->route('aturan-potongan.index')
            ->with('success', 'Aturan potongan berhasil disimpan.');
    }

    /**
     * Form edit aturan
     */
    public function edit(AturanPotonganJabatan $aturan_potongan)
    {
        return view('aturan_potongan.edit', compact('aturan_potongan'));
    }

    /**
     * Update aturan potongan
     */
    public function update(Request $request, AturanPotonganJabatan $aturan_potongan)
    {
        $request->validate([
            'potongan_hadir' => 'nullable|numeric|min:0',
            'potongan_terlambat' => 'nullable|numeric|min:0',
            'potongan_izin' => 'nullable|numeric|min:0',
            'potongan_sakit' => 'nullable|numeric|min:0',
            'potongan_alpa' => 'nullable|numeric|min:0',
            'potongan_cuti' => 'nullable|numeric|min:0',
        ]);

        $aturan_potongan->update([
            'potongan_hadir' => $request->potongan_hadir ?? 0,
            'potongan_terlambat' => $request->potongan_terlambat ?? 0,
            'potongan_izin' => $request->potongan_izin ?? 0,
            'potongan_sakit' => $request->potongan_sakit ?? 0,
            'potongan_alpa' => $request->potongan_alpa ?? 0,
            'potongan_cuti' => $request->potongan_cuti ?? 0,
        ]);

        return redirect()->route('aturan-potongan.index')
            ->with('success', 'Aturan potongan berhasil diperbarui.');
    }

    /**
     * Hapus aturan potongan
     */
    public function destroy(AturanPotonganJabatan $aturan_potongan)
    {
        $aturan_potongan->delete();

        return back()->with('success', 'Aturan potongan berhasil dihapus.');
    }
}
