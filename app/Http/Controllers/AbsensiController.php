<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\KaryawanShift;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $query = Absensi::with(['karyawan', 'shift'])
            ->orderBy('tanggal', 'desc');

        if ($user->role === 'Karyawan') {
            $query->where('karyawan_id', $user->karyawan_id);
        }

        $absensi = $query->get();

        $todayAbsen = null;

        if ($user->role === 'Karyawan') {
            $todayAbsen = Absensi::with('shift')
                ->where('karyawan_id', $user->karyawan_id)
                ->whereDate('tanggal', now())
                ->first();
        }

        return view('absensi.index', compact('absensi', 'todayAbsen'));
    }

    /*
    |--------------------------------------------------------------------------
    | ABSEN MASUK (AJAX JSON RESPONSE)
    |--------------------------------------------------------------------------
    */

    public function absenMasuk()
    {
        $user = Auth::user();
        $karyawanId = $user->karyawan_id;
        $tanggal = Carbon::today()->toDateString();

        if (!$karyawanId) {
            return response()->json([
                'message' => 'Data karyawan tidak ditemukan.'
            ], 400);
        }

        // Ambil jadwal shift hari ini
        $jadwalShift = KaryawanShift::where('karyawan_id', $karyawanId)
            ->whereDate('tanggal', $tanggal)
            ->first();

        if (!$jadwalShift) {
            return response()->json([
                'message' => 'Shift hari ini belum diatur oleh HRD.'
            ], 400);
        }

        // Cek sudah absen atau belum
        $cek = Absensi::where('karyawan_id', $karyawanId)
            ->whereDate('tanggal', $tanggal)
            ->first();

        if ($cek) {
            return response()->json([
                'message' => 'Anda sudah absen hari ini.'
            ], 400);
        }

        // Optional: otomatis terlambat
        $shift = Shift::find($jadwalShift->shift_id);
        $jamSekarang = Carbon::now();
        $jamShift = Carbon::parse($shift->jam_masuk);

        $status = $jamSekarang->gt($jamShift) ? 'Terlambat' : 'Hadir';

        Absensi::create([
            'karyawan_id' => $karyawanId,
            'shift_id'     => $jadwalShift->shift_id,
            'tanggal'      => $tanggal,
            'jam_masuk'    => $jamSekarang->format('H:i:s'),
            'status'       => $status,
        ]);

        return response()->json([
            'message' => 'Absen masuk berhasil.'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | ABSEN KELUAR (AJAX JSON RESPONSE)
    |--------------------------------------------------------------------------
    */

    public function absenKeluar()
    {
        $karyawanId = Auth::user()->karyawan_id;
        $tanggal = Carbon::today()->toDateString();

        $absensi = Absensi::where('karyawan_id', $karyawanId)
            ->whereDate('tanggal', $tanggal)
            ->first();

        if (!$absensi) {
            return response()->json([
                'message' => 'Anda belum absen masuk.'
            ], 400);
        }

        if ($absensi->jam_keluar) {
            return response()->json([
                'message' => 'Anda sudah absen keluar.'
            ], 400);
        }

        $absensi->update([
            'jam_keluar' => Carbon::now()->format('H:i:s'),
        ]);

        return response()->json([
            'message' => 'Absen keluar berhasil.'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | HRD ONLY
    |--------------------------------------------------------------------------
    */

    public function edit(Absensi $absensi)
    {
        $shift = Shift::all();
        return view('absensi.edit', compact('absensi', 'shift'));
    }

    public function update(Request $request, Absensi $absensi)
    {
        $request->validate([
            'shift_id' => 'required|exists:shift,id',
            'jam_masuk' => 'nullable',
            'jam_keluar' => 'nullable',
            'status' => 'required',
        ]);

        $absensi->update([
            'shift_id' => $request->shift_id,
            'jam_masuk' => $request->jam_masuk,
            'jam_keluar' => $request->jam_keluar,
            'status' => $request->status,
        ]);

        return redirect()->route('absensi.index')
            ->with('success', 'Data absensi berhasil diperbarui.');
    }

    public function destroy(Absensi $absensi)
    {
        $absensi->delete();

        return back()->with('success', 'Data absensi berhasil dihapus.');
    }
}
