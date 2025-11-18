<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Jabatan;
use App\Models\Departemen;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::with(['jabatan', 'departemen'])->get();
        return view('karyawan.index', compact('karyawan'));
    }

    public function create()
    {
        $jabatan = Jabatan::all();
        $departemen = Departemen::all();
        return view('karyawan.create', compact('jabatan', 'departemen'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nip' => 'required|unique:karyawan,nip',
        'nama' => 'required',
        'jabatan_id' => 'required',
        'departemen_id' => 'required',
        'tgl_masuk' => 'required|date',
        'status' => 'required',
        'email' => 'nullable|email',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $data = $request->all();

    // Upload Foto
    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $namaFile = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('foto_karyawan'), $namaFile);
        $data['foto'] = $namaFile;
    }

    // SIMPAN DATA
    Karyawan::create($data);

    return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan');
}


    public function edit(Karyawan $karyawan)
    {
        $jabatan = Jabatan::all();
        $departemen = Departemen::all();
        return view('karyawan.edit', compact('karyawan', 'jabatan', 'departemen'));
    }

    public function update(Request $request, Karyawan $karyawan)
{
    $request->validate([
        'nip' => 'required|unique:karyawan,nip,' . $karyawan->id,
        'nama' => 'required',
        'jabatan_id' => 'required',
        'departemen_id' => 'required',
        'tgl_masuk' => 'required|date',
        'status' => 'required',
        'email' => 'nullable|email',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $data = $request->all();

    // Jika upload foto baru
    if ($request->hasFile('foto')) {

        // Hapus foto lama
        if ($karyawan->foto && file_exists(public_path('foto_karyawan/' . $karyawan->foto))) {
            unlink(public_path('foto_karyawan/' . $karyawan->foto));
        }

        $file = $request->file('foto');
        $namaFile = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('foto_karyawan'), $namaFile);

        $data['foto'] = $namaFile;
    }

    // UPDATE DATA
    $karyawan->update($data);

    return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui');
}


    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();
        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil dihapus');
    }
}
