<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    /**
     * Tampilkan daftar absensi
     * - HRD → lihat semua absensi dengan filter
     * - Karyawan → hanya absensi miliknya sendiri
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Inisialisasi variable default
        $shiftHariIni = null;
        $sudahAbsen = false;
        $karyawan = null; // ← TAMBAHKAN INI

        // Query dasar
        $query = Absensi::with(['karyawan.jabatan', 'karyawan.departemen', 'shift']);

        // Filter berdasarkan role
        if ($user->role === 'Karyawan') {
            $karyawan = $user->karyawan; // ← SET VARIABLE INI

            if (!$karyawan) {
                return redirect()->route('dashboard')
                    ->with('error', 'Data karyawan belum tersedia untuk user ini.');
            }

            $query->where('karyawan_id', $karyawan->id);

            // Tambahkan info shift hari ini untuk karyawan
            $tanggal = now()->toDateString();
            $shiftHariIni = $karyawan->karyawanShift()
                ->where('tanggal', $tanggal)
                ->with('shift')
                ->first();

            // Cek apakah sudah absen hari ini
            $sudahAbsen = Absensi::where('karyawan_id', $karyawan->id)
                ->where('tanggal', $tanggal)
                ->exists();
        }

        // Filter tambahan untuk HRD
        if ($user->role === 'HRD') {
            if ($request->filled('karyawan_id')) {
                $query->where('karyawan_id', $request->karyawan_id);
            }

            if ($request->filled('bulan')) {
                $query->whereMonth('tanggal', $request->bulan);
            }

            if ($request->filled('tahun')) {
                $query->whereYear('tanggal', $request->tahun);
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
        }

        // Urutkan dari yang terbaru
        $absensi = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam_masuk', 'desc')
            ->paginate(20);

        // Data untuk filter (hanya untuk HRD)
        $karyawanList = [];
        if ($user->role === 'HRD') {
            $karyawanList = Karyawan::orderBy('nama')->get();
        }

        // ← TAMBAHKAN $karyawan DI COMPACT
        return view('absensi.index', compact('absensi', 'karyawanList', 'shiftHariIni', 'sudahAbsen', 'karyawan'));
    }

    /**
     * Tampilkan form absen masuk (untuk karyawan)
     */
    public function create()
    {
        $user = Auth::user();

        if ($user->role !== 'Karyawan') {
            return redirect()->route('absensi.index')
                ->with('error', 'Hanya karyawan yang bisa melakukan absensi');
        }

        $karyawan = $user->karyawan;
        if (!$karyawan) {
            return back()->with('error', 'Data karyawan belum tersedia untuk user ini.');
        }

        $tanggal = now()->toDateString();

        // Cek apakah sudah absen hari ini
        $sudahAbsen = Absensi::where('karyawan_id', $karyawan->id)
            ->where('tanggal', $tanggal)
            ->exists();

        if ($sudahAbsen) {
            return redirect()->route('absensi.index')
                ->with('info', 'Anda sudah melakukan absensi hari ini');
        }

        // Ambil shift karyawan untuk hari ini
        $shiftHariIni = $karyawan->karyawanShift()
            ->where('tanggal', $tanggal)
            ->with('shift')
            ->first();

        if (!$shiftHariIni) {
            return redirect()->route('absensi.index')
                ->with('error', 'Anda tidak memiliki jadwal shift untuk hari ini');
        }

        return view('absensi.create', compact('shiftHariIni', 'karyawan'));
    }

    /**
     * Absen masuk karyawan
     */
    public function absenMasuk(Request $request)
    {
        $user = Auth::user();
        $karyawan = $user->karyawan;

        if (!$karyawan) {
            return back()->with('error', 'Data karyawan belum tersedia untuk user ini.');
        }

        $tanggal = now()->toDateString();

        // Cek apakah sudah absen hari ini
        if (
            Absensi::where('karyawan_id', $karyawan->id)
                ->where('tanggal', $tanggal)
                ->exists()
        ) {
            return back()->with('error', 'Anda sudah absen hari ini.');
        }

        // Ambil shift dari jadwal karyawan
        $shiftHariIni = $karyawan->karyawanShift()
            ->where('tanggal', $tanggal)
            ->with('shift')
            ->first();

        if (!$shiftHariIni) {
            return back()->with('error', 'Anda tidak memiliki jadwal shift hari ini.');
        }

        $shift = $shiftHariIni->shift;
        $jamSekarang = now()->format('H:i:s');

        // Validasi jam masuk sesuai shift (dengan toleransi 2 jam sebelum dan sesudah)
        $jamMulai = Carbon::createFromFormat('H:i:s', $shift->jam_mulai);
        $jamSelesai = Carbon::createFromFormat('H:i:s', $shift->jam_selesai);
        $jamNow = Carbon::createFromFormat('H:i:s', $jamSekarang);

        $batasAwal = $jamMulai->copy()->subHours(2);
        $batasAkhir = $jamSelesai->copy()->addHours(2);

        // Jika shift melewati tengah malam
        if ($jamSelesai->lt($jamMulai)) {
            $batasAkhir->addDay();
        }

        if ($jamNow->lt($batasAwal) || $jamNow->gt($batasAkhir)) {
            return back()->with('error', 'Waktu absensi tidak sesuai dengan jadwal shift Anda.');
        }

        // Tentukan status Hadir / Terlambat
        $status = $jamSekarang > $shift->jam_mulai ? 'Terlambat' : 'Hadir';

        // Simpan absensi
        Absensi::create([
            'karyawan_id' => $karyawan->id,
            'shift_id' => $shift->id,
            'tanggal' => $tanggal,
            'jam_masuk' => $jamSekarang,
            'status' => $status,
        ]);

        return back()->with('success', 'Absensi masuk berhasil dicatat.');
    }

    /**
     * Absen keluar karyawan
     */
    public function absenKeluar(Request $request)
    {
        $user = Auth::user();
        $karyawan = $user->karyawan;

        if (!$karyawan) {
            return back()->with('error', 'Data karyawan belum tersedia untuk user ini.');
        }

        $tanggal = now()->toDateString();

        // Cari absensi hari ini
        $absensi = Absensi::where('karyawan_id', $karyawan->id)
            ->where('tanggal', $tanggal)
            ->first();

        if (!$absensi) {
            return back()->with('error', 'Anda belum absen masuk.');
        }

        if ($absensi->jam_keluar !== null) {
            return back()->with('error', 'Anda sudah absen keluar.');
        }

        $jamSekarang = now()->format('H:i:s');

        // Update jam keluar
        $absensi->update([
            'jam_keluar' => $jamSekarang,
        ]);

        return back()->with('success', 'Absensi keluar berhasil dicatat.');
    }

    /**
     * Edit absensi (Hanya HRD)
     */
    public function edit($id)
    {
        $user = Auth::user();

        if ($user->role !== 'HRD') {
            return redirect()->route('absensi.index')
                ->with('error', 'Anda tidak memiliki akses');
        }

        $absensi = Absensi::with(['karyawan', 'shift'])->findOrFail($id);
        $shifts = Shift::all();
        $karyawanList = Karyawan::orderBy('nama')->get();

        return view('absensi.edit', compact('absensi', 'shifts', 'karyawanList'));
    }

    /**
     * Update absensi (Hanya HRD)
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        if ($user->role !== 'HRD') {
            return redirect()->route('absensi.index')
                ->with('error', 'Anda tidak memiliki akses');
        }

        $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
            'tanggal' => 'required|date',
            'shift_id' => 'required|exists:shift,id',
            'jam_masuk' => 'required',
            'jam_keluar' => 'nullable',
            'status' => 'required|in:Hadir,Terlambat,Izin,Sakit,Alpa,Cuti'
        ]);

        $absensi = Absensi::findOrFail($id);
        $absensi->update([
            'karyawan_id' => $request->karyawan_id,
            'tanggal' => $request->tanggal,
            'shift_id' => $request->shift_id,
            'jam_masuk' => $request->jam_masuk,
            'jam_keluar' => $request->jam_keluar,
            'status' => $request->status
        ]);

        return redirect()->route('absensi.index')
            ->with('success', 'Data absensi berhasil diupdate');
    }

    /**
     * Delete absensi (Hanya HRD)
     */
    public function destroy($id)
    {
        $user = Auth::user();

        if ($user->role !== 'HRD') {
            return redirect()->route('absensi.index')
                ->with('error', 'Anda tidak memiliki akses');
        }

        $absensi = Absensi::findOrFail($id);
        $absensi->delete();

        return redirect()->route('absensi.index')
            ->with('success', 'Data absensi berhasil dihapus');
    }

    /**
     * Laporan absensi (HRD)
     */
    public function laporan(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'HRD') {
            return redirect()->route('absensi.index')
                ->with('error', 'Anda tidak memiliki akses');
        }

        $query = Absensi::with(['karyawan', 'shift']);

        // Filter
        if ($request->filled('karyawan_id')) {
            $query->where('karyawan_id', $request->karyawan_id);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        } else {
            // Default tahun ini
            $query->whereYear('tanggal', date('Y'));
        }

        $absensi = $query->orderBy('tanggal', 'desc')->get();

        // Statistik
        $statistik = [
            'total' => $absensi->count(),
            'hadir' => $absensi->where('status', 'Hadir')->count(),
            'terlambat' => $absensi->where('status', 'Terlambat')->count(),
            'izin' => $absensi->where('status', 'Izin')->count(),
            'sakit' => $absensi->where('status', 'Sakit')->count(),
            'alpa' => $absensi->where('status', 'Alpa')->count(),
            'cuti' => $absensi->where('status', 'Cuti')->count()
        ];

        $karyawanList = Karyawan::orderBy('nama')->get();

        return view('absensi.laporan', compact('absensi', 'statistik', 'karyawanList'));
    }

    /**
     * Tambah absensi manual (Hanya HRD)
     */
    public function tambah()
    {
        $user = Auth::user();

        if ($user->role !== 'HRD') {
            return redirect()->route('absensi.index')
                ->with('error', 'Anda tidak memiliki akses');
        }

        $karyawanList = Karyawan::orderBy('nama')->get();
        $shifts = Shift::all();

        return view('absensi.tambah', compact('karyawanList', 'shifts'));
    }

    /**
     * Simpan absensi manual (Hanya HRD)
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'HRD') {
            return redirect()->route('absensi.index')
                ->with('error', 'Anda tidak memiliki akses');
        }

        $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
            'tanggal' => 'required|date',
            'shift_id' => 'required|exists:shift,id',
            'jam_masuk' => 'required',
            'jam_keluar' => 'nullable',
            'status' => 'required|in:Hadir,Terlambat,Izin,Sakit,Alpa,Cuti'
        ]);

        // Cek duplikat
        $exists = Absensi::where('karyawan_id', $request->karyawan_id)
            ->where('tanggal', $request->tanggal)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Karyawan sudah memiliki absensi pada tanggal tersebut.')
                ->withInput();
        }

        Absensi::create([
            'karyawan_id' => $request->karyawan_id,
            'shift_id' => $request->shift_id,
            'tanggal' => $request->tanggal,
            'jam_masuk' => $request->jam_masuk,
            'jam_keluar' => $request->jam_keluar,
            'status' => $request->status
        ]);

        return redirect()->route('absensi.index')
            ->with('success', 'Data absensi berhasil ditambahkan');
    }

    
    
}