<?php

namespace App\Http\Controllers;

use App\Models\AturanPotonganJabatan;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class AturanPotonganJabatanController extends Controller
{
    /**
     * List aturan potongan
     */
    public function index()
    {
        $aturan = AturanPotonganJabatan::with('jabatan')->get();
        return view('aturan-potongan.index', compact('aturan'));
    }

    /**
     * Form tambah aturan
     */
    public function create()
    {
        $jabatan = Jabatan::all();
        return view('aturan-potongan.create', compact('jabatan'));
    }

    /**
     * Simpan aturan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'jabatan_id' => 'required|exists:jabatan,id',
            'potongan_per_absen' => 'required|numeric|min:0',
        ]);

        AturanPotonganJabatan::updateOrCreate(
            ['jabatan_id' => $request->jabatan_id],
            ['potongan_per_absen' => $request->potongan_per_absen]
        );

        return redirect()
            ->route('aturan-potongan.index')
            ->with('success', 'Aturan potongan berhasil disimpan.');
    }

    /**
     * Form edit aturan
     */
    public function edit($id)
    {
        $aturan = AturanPotonganJabatan::findOrFail($id);
        $jabatan = Jabatan::all();

        return view('aturan-potongan.edit', compact('aturan', 'jabatan'));
    }

    /**
     * Update aturan
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'jabatan_id' => 'required|exists:jabatan,id',
            'potongan_per_absen' => 'required|numeric|min:0',
        ]);

        $aturan = AturanPotonganJabatan::findOrFail($id);
        $aturan->update([
            'jabatan_id' => $request->jabatan_id,
            'potongan_per_absen' => $request->potongan_per_absen,
        ]);

        return redirect()
            ->route('aturan-potongan.index')
            ->with('success', 'Aturan potongan berhasil diperbarui.');
    }

    /**
     * Hapus aturan
     */
    public function destroy($id)
    {
        AturanPotonganJabatan::findOrFail($id)->delete();

        return redirect()
            ->route('aturan-potongan.index')
            ->with('success', 'Aturan potongan berhasil dihapus.');
    }
}
