<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Shift;
use App\Models\KaryawanShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KaryawanShiftController extends Controller
{
    /**
     * Menampilkan halaman jadwal shift karyawan
     */
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        $karyawan = Karyawan::with('departemen')
            ->orderBy('nama')
            ->get();

        $shifts = Shift::orderBy('nama_shift')->get();

        $jadwalShift = KaryawanShift::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get()
            ->groupBy('karyawan_id');

        return view('karyawan_shift.index', compact(
            'karyawan',
            'shifts',
            'jadwalShift',
            'bulan',
            'tahun'
        ));
    }


    /**
     * Simpan 1 jadwal shift
     */
    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
            'shift_id' => 'required|exists:shift,id',
            'tanggal' => 'required|date',
        ]);

        // Hindari double shift di tanggal yang sama
        $exists = KaryawanShift::where('karyawan_id', $request->karyawan_id)
            ->where('tanggal', $request->tanggal)
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'tanggal' => 'Karyawan sudah memiliki shift pada tanggal tersebut'
            ]);
        }

        KaryawanShift::create($request->all());

        return back()->with('success', 'Jadwal shift berhasil disimpan');
    }

    /**
     * Simpan banyak jadwal sekaligus (bulk)
     */
    public function bulkStore(Request $request)
    {
        $request->validate([
            'schedules' => 'required|array',
            'schedules.*.karyawan_id' => 'required|exists:karyawan,id',
            'schedules.*.shift_id' => 'required|exists:shift,id',
            'schedules.*.tanggal' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->schedules as $schedule) {
                KaryawanShift::updateOrCreate(
                    [
                        'karyawan_id' => $schedule['karyawan_id'],
                        'tanggal' => $schedule['tanggal'],
                    ],
                    [
                        'shift_id' => $schedule['shift_id'],
                    ]
                );
            }
        });

        return response()->json([
            'message' => 'Jadwal shift berhasil disimpan!'
        ]);
    }


    /**
     * Hapus jadwal shift
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:karyawan_shift,id',
        ]);

        KaryawanShift::findOrFail($request->id)->delete();

        return back()->with('success', 'Jadwal shift berhasil dihapus');
    }

    /**
     * Ambil jadwal untuk kalender / ajax
     */
    public function getSchedule(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'nullable|exists:karyawan,id',
            'tanggal' => 'nullable|date',
        ]);

        $query = KaryawanShift::with(['karyawan', 'shift']);

        if ($request->karyawan_id) {
            $query->where('karyawan_id', $request->karyawan_id);
        }

        if ($request->tanggal) {
            $query->where('tanggal', $request->tanggal);
        }

        return response()->json($query->get());
    }
}
