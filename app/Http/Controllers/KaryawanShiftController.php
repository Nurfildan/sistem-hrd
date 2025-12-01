<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Shift;
use App\Models\KaryawanShift;
use Illuminate\Http\Request;

class KaryawanShiftController extends Controller
{
    public function index()
    {
        $jadwal = KaryawanShift::with(['karyawan', 'shift'])->get();
        return view('karyawan_shift.index', compact('jadwal'));
    }

    public function create()
    {
        $karyawan = Karyawan::all();
        $shift = Shift::all();
        return view('karyawan_shift.create', compact('karyawan', 'shift'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required',
            'shift_id' => 'required',
            'tanggal' => 'required|date',
        ]);

        KaryawanShift::create($request->all());
        return redirect()->route('karyawan_shift.index')->with('success', 'Jadwal shift berhasil ditambahkan.');
    }

    public function destroy(KaryawanShift $karyawanShift)
    {
        $karyawanShift->delete();
        return redirect()->route('karyawan_shift.index')->with('success', 'Jadwal shift dihapus.');
    }

    public function edit(KaryawanShift $karyawanShift)
{
    $karyawan = Karyawan::all();
    $shift = Shift::all();
    return view('karyawan_shift.edit', compact('karyawanShift', 'karyawan', 'shift'));
}

public function update(Request $request, KaryawanShift $karyawanShift)
{
    $request->validate([
        'karyawan_id' => 'required',
        'shift_id' => 'required',
        'tanggal' => 'required|date',
    ]);

    $karyawanShift->update($request->all());
    return redirect()->route('karyawan_shift.index')->with('success', 'Jadwal shift berhasil diperbarui.');
}
}
