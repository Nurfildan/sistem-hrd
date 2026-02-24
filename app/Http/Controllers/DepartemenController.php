<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    public function index()
    {
        $departemen = Departemen::orderBy('nama_departemen')->get();
        return view('admin.departemen.index', compact('departemen'));
    }

    public function create()
    {
        return view('admin.departemen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_departemen' => 'required|string|max:100|unique:departemen,nama_departemen',
        ]);

        Departemen::create([
            'nama_departemen' => $request->nama_departemen,
        ]);

        return redirect()
            ->route('admin.departemen.index')
            ->with('success', 'Departemen berhasil ditambahkan');
    }

    public function edit(Departemen $departemen)
    {
        return view('admin.departemen.edit', compact('departemen'));
    }

    public function update(Request $request, Departemen $departemen)
    {
        $request->validate([
            'nama_departemen' => 'required|string|max:100|unique:departemen,nama_departemen,' . $departemen->id,
        ]);

        $departemen->update([
            'nama_departemen' => $request->nama_departemen,
        ]);

        return redirect()
            ->route('admin.departemen.index')
            ->with('success', 'Departemen berhasil diperbarui');
    }

    public function destroy(Departemen $departemen)
    {
        $departemen->delete();

        return redirect()
            ->route('admin.departemen.index')
            ->with('success', 'Departemen berhasil dihapus');
    }
}
