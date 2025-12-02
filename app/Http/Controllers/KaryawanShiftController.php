<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Shift;
use App\Models\KaryawanShift;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KaryawanShiftController extends Controller
{
    public function index(Request $request)
    {
        // Ambil bulan dan tahun dari request, default ke bulan sekarang
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);
        
        // Ambil semua karyawan dengan departemen
        $karyawan = Karyawan::with('departemen')->get();
        
        // Ambil semua shift
        $shifts = Shift::all();
        
        // Ambil jadwal shift untuk bulan dan tahun yang dipilih
        $jadwalShift = KaryawanShift::with(['karyawan', 'shift'])
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get()
            ->groupBy('karyawan_id');
        
        return view('karyawan_shift.index', compact('karyawan', 'shifts', 'jadwalShift', 'bulan', 'tahun'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
            'shift_id' => 'required|exists:shift,id',
            'tanggal' => 'required|date',
        ]);

        // Cek apakah sudah ada jadwal untuk karyawan di tanggal tersebut
        $existing = KaryawanShift::where('karyawan_id', $request->karyawan_id)
            ->where('tanggal', $request->tanggal)
            ->first();

        if ($existing) {
            // Update jika sudah ada
            $existing->update(['shift_id' => $request->shift_id]);
        } else {
            // Buat baru jika belum ada
            KaryawanShift::create($request->all());
        }

        return response()->json(['success' => true, 'message' => 'Jadwal shift berhasil disimpan']);
    }

    public function bulkStore(Request $request)
    {
        $request->validate([
            'schedules' => 'required|array',
            'schedules.*.karyawan_id' => 'required|exists:karyawan,id',
            'schedules.*.shift_id' => 'required|exists:shift,id',
            'schedules.*.tanggal' => 'required|date',
        ]);

        foreach ($request->schedules as $schedule) {
            $existing = KaryawanShift::where('karyawan_id', $schedule['karyawan_id'])
                ->where('tanggal', $schedule['tanggal'])
                ->first();

            if ($existing) {
                $existing->update(['shift_id' => $schedule['shift_id']]);
            } else {
                KaryawanShift::create($schedule);
            }
        }

        return response()->json(['success' => true, 'message' => 'Semua jadwal shift berhasil disimpan']);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
            'tanggal' => 'required|date',
        ]);

        KaryawanShift::where('karyawan_id', $request->karyawan_id)
            ->where('tanggal', $request->tanggal)
            ->delete();

        return response()->json(['success' => true, 'message' => 'Jadwal shift berhasil dihapus']);
    }

    public function getSchedule(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);
        
        $jadwal = KaryawanShift::with(['karyawan', 'shift'])
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        return response()->json($jadwal);
    }
}