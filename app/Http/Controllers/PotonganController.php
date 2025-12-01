<?php

namespace App\Http\Controllers;

use App\Models\Potongan;
use App\Models\Karyawan;
use App\Models\Absensi;
use App\Models\Cuti;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PotonganController extends Controller
{
    public function index()
    {
        $potongan = Potongan::with('karyawan')->get();
        return view('potongan.index', compact('potongan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required',
            'nama_potongan' => 'required',
            'jumlah' => 'required|numeric',
            'bulan' => 'required'
        ]);

        Potongan::create($request->all());
        return redirect()->route('potongan.index')->with('success', 'Potongan berhasil ditambahkan.');
    }

    public function edit(Potongan $potongan)
    {
        return view('potongan.edit', compact('potongan'));
    }

    public function update(Request $request, Potongan $potongan)
    {
        $request->validate([
            'nama_potongan' => 'required',
            'jumlah' => 'required|numeric',
        ]);

        $potongan->update($request->all());
        return redirect()->route('potongan.index')->with('success', 'Potongan berhasil diupdate.');
    }

    public function destroy(Potongan $potongan)
    {
        $potongan->delete();
        return back()->with('success', 'Potongan dihapus.');
    }

    public function showKaryawan($id)
    {
        $karyawan = Karyawan::with(['absensi', 'cuti', 'potongan'])->findOrFail($id);
        return view('potongan.detail', compact('karyawan'));
    }

    public function generatePotongan($bulan, $tahun)
    {
        $karyawans = Karyawan::all();

        foreach ($karyawans as $karyawan) {
            $potonganTotal = 0;

            // Absensi
            $absensi = Absensi::where('karyawan_id', $karyawan->id)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->get();

            foreach ($absensi as $a) {
                if ($a->status == 'Alpa') $potonganTotal += 50000;
                if ($a->status == 'Cuti') $potonganTotal += 100000;
            }

            // Cuti resmi disetujui
            $cutis = Cuti::where('karyawan_id', $karyawan->id)
                ->where('status', 'Disetujui')
                ->get();

            foreach ($cutis as $c) {
                $start = Carbon::parse($c->tanggal_mulai);
                $end = Carbon::parse($c->tanggal_selesai);
                $hariCuti = $start->diffInDays($end) + 1;
                $potonganTotal += 100000 * $hariCuti;
            }

            // Simpan
            Potongan::updateOrCreate(
                ['karyawan_id' => $karyawan->id, 'bulan' => $bulan.'-'.$tahun],
                ['nama_potongan' => 'Potongan Absensi & Cuti', 'jumlah' => $potonganTotal]
            );
        }

        return redirect()->route('potongan.index')->with('success', 'Potongan otomatis berhasil dihitung.');
    }
}
