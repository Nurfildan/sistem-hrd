<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Karyawan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CutiController extends Controller
{
    /**
     * List cuti
     * - HRD: semua karyawan
     * - Karyawan: milik sendiri
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $karyawanList = collect();

        $query = Cuti::with('karyawan')
            ->orderBy('created_at', 'desc');

        // Kalau Karyawan → hanya milik sendiri
        if ($user->role === 'Karyawan') {
            $query->where('karyawan_id', $user->karyawan_id);
        }

        // Filter khusus HRD
        if ($user->role === 'HRD') {

            if ($request->karyawan_id) {
                $query->where('karyawan_id', $request->karyawan_id);
            }

            if ($request->status) {
                $query->where('status', $request->status);
            }

            $karyawanList = Karyawan::orderBy('nama')->get();
        }

        $cuti = $query->paginate(10);

        return view('cuti.index', compact('cuti', 'karyawanList'));
    }


    /**
     * Form pengajuan cuti (KHUSUS KARYAWAN)
     */
    public function create()
    {
        return view('cuti.create');
    }

    /**
     * Simpan pengajuan cuti (KHUSUS KARYAWAN)
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'nullable|string',
        ]);

        Cuti::create([
            'karyawan_id' => Auth::user()->karyawan_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keterangan' => $request->keterangan,
            'status' => 'Menunggu',
        ]);

        return redirect()->route('cuti.index')
            ->with('success', 'Pengajuan cuti berhasil dikirim.');
    }

    /**
     * Detail cuti (HRD & Karyawan)
     */
    public function show(Cuti $cuti)
    {
        $this->authorizeAccess($cuti);

        return view('cuti.show', compact('cuti'));
    }

    /**
     * Form edit cuti (KHUSUS HRD)
     */
    public function edit(Cuti $cuti)
    {
        return view('cuti.edit', compact('cuti'));
    }

    /**
     * Update data cuti (KHUSUS HRD)
     */
    public function update(Request $request, Cuti $cuti)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:Menunggu,Disetujui,Ditolak',
            'keterangan' => 'nullable|string',
        ]);

        $cuti->update([
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('cuti.index')
            ->with('success', 'Data cuti berhasil diperbarui.');
    }

    /**
     * Hapus cuti (KHUSUS HRD)
     */
    public function destroy(Cuti $cuti)
    {
        $cuti->delete();

        return back()->with('success', 'Data cuti berhasil dihapus.');
    }

    /**
     * Guard sederhana:
     * Karyawan hanya boleh lihat milik sendiri
     */
    private function authorizeAccess(Cuti $cuti)
    {
        if (
            Auth::user()->role === 'Karyawan' &&
            Auth::user()->karyawan_id !== $cuti->karyawan_id
        ) {
            abort(403, 'Akses ditolak');
        }
    }
}
