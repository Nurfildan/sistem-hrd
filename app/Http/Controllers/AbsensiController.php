<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\KaryawanShift;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    /**
     * ============================
     * INDEX
     * HRD  : semua absensi
     * KARY : absensi sendiri
     * ============================
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'HRD') {
            $absensi = Absensi::with(['karyawan', 'shift'])
                ->orderByDesc('tanggal')
                ->get();
        } else {
            if (!$user->karyawan_id) {
                abort(403);
            }

            $absensi = Absensi::with('shift')
                ->where('karyawan_id', $user->karyawan_id)
                ->orderByDesc('tanggal')
                ->get();
        }

        return view('absensi.index', compact('absensi'));
    }

    /**
     * ============================
     * ABSEN MASUK
     * ============================
     */
    public function absenMasuk()
    {
        $user = auth()->user();

        if (!$user->karyawan_id) {
            return back()->with('error', 'Akun tidak terhubung dengan data karyawan');
        }

        $today = now()->toDateString();

        $karyawanShift = KaryawanShift::with('shift')
            ->where('karyawan_id', $user->karyawan_id)
            ->whereDate('tanggal', $today)
            ->first();

        if (!$karyawanShift) {
            return back()->with('error', 'Anda tidak memiliki shift hari ini');
        }

        if (
            Absensi::where('karyawan_id', $user->karyawan_id)
                ->whereDate('tanggal', $today)
                ->exists()
        ) {
            return back()->with('error', 'Anda sudah absen hari ini');
        }

        $jamMasuk = now()->format('H:i:s');
        $jamShift = $karyawanShift->shift->jam_mulai;

        $status = $jamMasuk > $jamShift ? 'Terlambat' : 'Hadir';

        Absensi::create([
            'karyawan_id' => $user->karyawan_id,
            'shift_id' => $karyawanShift->shift_id,
            'tanggal' => $today,
            'jam_masuk' => $jamMasuk,
            'status' => $status,
        ]);

        return back()->with('success', 'Absen masuk berhasil');
    }

    /**
     * ============================
     * ABSEN KELUAR
     * ============================
     */
    public function absenKeluar()
    {
        $user = auth()->user();

        if (!$user->karyawan_id) {
            return back()->with('error', 'Akun tidak terhubung dengan data karyawan');
        }

        $today = now()->toDateString();

        $absensi = Absensi::where('karyawan_id', $user->karyawan_id)
            ->whereDate('tanggal', $today)
            ->first();

        if (!$absensi) {
            return back()->with('error', 'Anda belum absen masuk');
        }

        if ($absensi->jam_keluar) {
            return back()->with('error', 'Anda sudah absen keluar');
        }

        $absensi->update([
            'jam_keluar' => now()->format('H:i:s'),
        ]);

        return back()->with('success', 'Absen keluar berhasil');
    }

    public function edit(Absensi $absensi)
    {
        abort_if(auth()->user()->role !== 'HRD', 403);

        return view('absensi.edit', compact('absensi'));
    }

    /**
     * ============================
     * HRD - UPDATE
     * ============================
     */
    public function update(Request $request, $id)
    {
        abort_if(auth()->user()->role !== 'HRD', 403);

        $request->validate([
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_keluar' => 'nullable|date_format:H:i',
            'status' => 'required|in:Hadir,Terlambat,Izin,Sakit,Alpa,Cuti',
        ]);

        Absensi::findOrFail($id)->update($request->only([
            'jam_masuk',
            'jam_keluar',
            'status'
        ]));

        return back()->with('success', 'Absensi berhasil diperbarui');
    }

    /**
     * ============================
     * HRD - DELETE
     * ============================
     */
    public function destroy($id)
    {
        abort_if(auth()->user()->role !== 'HRD', 403);

        Absensi::findOrFail($id)->delete();

        return back()->with('success', 'Data absensi berhasil dihapus');
    }
}
