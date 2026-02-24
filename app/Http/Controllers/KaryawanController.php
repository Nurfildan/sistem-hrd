<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Jabatan;
use App\Models\Departemen;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    /**
     * Tampilkan daftar karyawan
     */
    public function index()
    {
        $karyawan = Karyawan::with(['jabatan', 'departemen'])->get();
        return view('karyawan.index', compact('karyawan'));
    }

    /**
     * Form tambah karyawan
     */
    public function create()
    {
        $jabatan = Jabatan::all();
        $departemen = Departemen::all();

        return view('karyawan.create', compact('jabatan', 'departemen'));
    }

    /**
     * Simpan data karyawan
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:karyawan,nip',
            'nama' => 'required',
            'jabatan_id' => 'required',
            'departemen_id' => 'required',
            'tgl_masuk' => 'required|date',
            'status' => 'required',
        ]);

        Karyawan::create($request->all());

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Karyawan berhasil ditambahkan');
    }

    /**
     * Detail karyawan
     */
    public function show($id)
    {
        $karyawan = Karyawan::with(['jabatan', 'departemen'])->findOrFail($id);
        return view('karyawan.show', compact('karyawan'));
    }

    /**
     * Form edit karyawan
     */
    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $jabatan = Jabatan::all();
        $departemen = Departemen::all();

        return view('karyawan.edit', compact('karyawan', 'jabatan', 'departemen'));
    }

    /**
     * Update data karyawan
     */
    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $request->validate([
            'nip' => 'required|unique:karyawan,nip,' . $karyawan->id,
            'nama' => 'required',
            'jabatan_id' => 'required',
            'departemen_id' => 'required',
            'tgl_masuk' => 'required|date',
            'status' => 'required',
        ]);

        $karyawan->update($request->all());

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil diperbarui');
    }

    /**
     * Hapus karyawan
     */
    public function destroy($id)
    {
        Karyawan::findOrFail($id)->delete();

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Karyawan berhasil dihapus');
    }
}
