<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CutiController extends Controller
{
    /**
     * Tampilkan daftar cuti
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = Cuti::with(['karyawan']);

        // Filter berdasarkan role
        if ($user->role === 'Karyawan') {
            $karyawan = $user->karyawan;
            
            if (!$karyawan) {
                return redirect()->route('dashboard')
                    ->with('error', 'Data karyawan Anda belum terdaftar.');
            }
            
            $query->where('karyawan_id', $karyawan->id);
        }

        // HRD bisa lihat semua cuti dengan filter
        if ($user->role === 'HRD') {
            if ($request->filled('karyawan_id')) {
                $query->where('karyawan_id', $request->karyawan_id);
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
        }

        $cuti = $query->orderBy('created_at', 'desc')->paginate(20);

        // Data untuk filter (hanya HRD)
        $karyawanList = [];
        if ($user->role === 'HRD') {
            $karyawanList = Karyawan::orderBy('nama')->get();
        }

        return view('cuti.index', compact('cuti', 'karyawanList'));
    }

    /**
     * Form pengajuan cuti (Karyawan)
     */
    public function create()
    {
        $user = Auth::user();
        
        if ($user->role !== 'Karyawan') {
            return redirect()->route('cuti.index')
                ->with('error', 'Hanya karyawan yang bisa mengajukan cuti');
        }

        return view('cuti.create');
    }

    /**
     * Simpan pengajuan cuti (Karyawan)
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $karyawan = $user->karyawan;

        if (!$karyawan) {
            return back()->with('error', 'Data karyawan belum tersedia.');
        }

        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'required|string|max:500'
        ]);

        Cuti::create([
            'karyawan_id' => $karyawan->id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keterangan' => $request->keterangan,
            'status' => 'Menunggu'
        ]);

        return redirect()->route('cuti.index')
            ->with('success', 'Pengajuan cuti berhasil diajukan');
    }

    /**
     * Detail cuti
     */
    public function show($id)
    {
        $user = Auth::user();
        $cuti = Cuti::with('karyawan')->findOrFail($id);

        // Karyawan hanya bisa lihat cuti sendiri
        if ($user->role === 'Karyawan' && $cuti->karyawan_id !== $user->karyawan->id) {
            abort(403, 'Anda tidak memiliki akses');
        }

        return view('cuti.show', compact('cuti'));
    }

    /**
     * Form edit cuti (HRD)
     */
    public function edit($id)
    {
        $user = Auth::user();

        if ($user->role !== 'HRD') {
            return redirect()->route('cuti.index')
                ->with('error', 'Anda tidak memiliki akses');
        }

        $cuti = Cuti::with('karyawan')->findOrFail($id);
        $karyawanList = Karyawan::orderBy('nama')->get();

        return view('cuti.edit', compact('cuti', 'karyawanList'));
    }

    /**
     * Update cuti (HRD)
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        if ($user->role !== 'HRD') {
            return redirect()->route('cuti.index')
                ->with('error', 'Anda tidak memiliki akses');
        }

        $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'required|string|max:500',
            'status' => 'required|in:Menunggu,Disetujui,Ditolak'
        ]);

        $cuti = Cuti::findOrFail($id);
        $cuti->update([
            'karyawan_id' => $request->karyawan_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keterangan' => $request->keterangan,
            'status' => $request->status
        ]);

        return redirect()->route('cuti.index')
            ->with('success', 'Data cuti berhasil diupdate');
    }

    /**
     * Hapus cuti (HRD)
     */
    public function destroy($id)
    {
        $user = Auth::user();

        if ($user->role !== 'HRD') {
            return redirect()->route('cuti.index')
                ->with('error', 'Anda tidak memiliki akses');
        }

        $cuti = Cuti::findOrFail($id);
        $cuti->delete();

        return redirect()->route('cuti.index')
            ->with('success', 'Data cuti berhasil dihapus');
    }

    /**
     * Update status cuti (HRD)
     */
    public function updateStatus(Request $request, $id)
    {
        $user = Auth::user();

        if ($user->role !== 'HRD') {
            return redirect()->route('cuti.index')
                ->with('error', 'Anda tidak memiliki akses');
        }

        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak'
        ]);

        $cuti = Cuti::findOrFail($id);
        $cuti->update([
            'status' => $request->status
        ]);

        return redirect()->route('cuti.index')
            ->with('success', 'Status cuti berhasil diupdate');
    }
}