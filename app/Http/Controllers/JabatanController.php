<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatan = Jabatan::all();
        return view('jabatan.index', compact('jabatan'));
    }

    public function create()
    {
        return view('jabatan.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_jabatan' => 'required',
        'gaji_pokok' => 'required',
        'tunjangan' => 'required',
    ]);

    // Hapus titik agar tetap angka murni
    $gaji = str_replace('.', '', $request->gaji_pokok);
    $tunjangan = str_replace('.', '', $request->tunjangan);

    Jabatan::create([
        'nama_jabatan' => $request->nama_jabatan,
        'gaji_pokok'   => $gaji,
        'tunjangan'    => $tunjangan,
    ]);

    return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil ditambahkan.');
}


    public function edit(Jabatan $jabatan)
    {
        return view('jabatan.edit', compact('jabatan'));
    }

    public function update(Request $request, Jabatan $jabatan)
{
    $gaji = str_replace('.', '', $request->gaji_pokok);
    $tunjangan = str_replace('.', '', $request->tunjangan);

    $jabatan->update([
        'nama_jabatan' => $request->nama_jabatan,
        'gaji_pokok' => str_replace('.', '', $request->gaji_pokok),
        'tunjangan' => str_replace('.', '', $request->tunjangan),
    ]);

    return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil diperbarui.');
}
public function destroy(Jabatan $jabatan)
{
    $jabatan->delete();
    return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil dihapus.');
}


}
