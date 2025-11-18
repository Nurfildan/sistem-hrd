<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index()
    {
        $shift = Shift::all();
        return view('shift.index', compact('shift'));
    }

    public function create()
    {
        return view('shift.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_shift' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'keterangan' => 'nullable',
        ]);

        Shift::create($request->all());
        return redirect()->route('shift.index')->with('success', 'Shift berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $shift = Shift::findOrFail($id);
        return view('shift.edit', compact('shift'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_shift' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'keterangan' => 'nullable',
        ]);

        $shift = Shift::findOrFail($id);
        $shift->update($request->all());

        return redirect()->route('shift.index')->with('success', 'Shift berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $shift = Shift::findOrFail($id);
        $shift->delete();

        return redirect()->route('shift.index')->with('success', 'Shift berhasil dihapus.');
    }
}
