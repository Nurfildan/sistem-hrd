<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\KaryawanShift;
use Carbon\Carbon;
use Auth;

class AbsensiController extends Controller
{
    public function index()
    {
        $karyawan = Auth::user()->karyawan;
        $today = Carbon::today();

        // Ambil shift hari ini
        $jadwal = KaryawanShift::with('shift')
            ->where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', $today)
            ->first();

        // Ambil absensi hari ini
        $absensi = Absensi::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', $today)
            ->first();

        return view('absensi.index', compact('jadwal', 'absensi'));
    }

    public function absenMasuk()
    {
        $karyawan = Auth::user()->karyawan;
        $now = Carbon::now();
        $today = Carbon::today();

        // Cegah double absen
        if (Absensi::where('karyawan_id', $karyawan->id)->whereDate('tanggal', $today)->exists()) {
            return back()->with('error', 'Anda sudah absen hari ini');
        }

        $jadwal = KaryawanShift::with('shift')
            ->where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', $today)
            ->firstOrFail();

        // Cek terlambat
        $jamMasukShift = Carbon::parse($jadwal->shift->jam_mulai);
        $status = $now->gt($jamMasukShift) ? 'Terlambat' : 'Hadir';

        Absensi::create([
            'karyawan_id' => $karyawan->id,
            'shift_id' => $jadwal->shift_id,
            'tanggal' => $today,
            'jam_masuk' => $now->format('H:i:s'),
            'status' => $status,
        ]);

        return back()->with('success', 'Absen masuk berhasil');
    }

    public function absenKeluar()
    {
        $karyawan = Auth::user()->karyawan;
        $today = Carbon::today();

        $absensi = Absensi::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', $today)
            ->firstOrFail();

        if ($absensi->jam_keluar) {
            return back()->with('error', 'Anda sudah absen pulang');
        }

        $absensi->update([
            'jam_keluar' => Carbon::now()->format('H:i:s'),
        ]);

        return back()->with('success', 'Absen pulang berhasil');
    }
}
