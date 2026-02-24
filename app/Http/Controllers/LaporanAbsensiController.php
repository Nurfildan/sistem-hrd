<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanAbsensiController extends Controller
{
    public function index(Request $request)
    {
        $absensi = $this->getData($request);

        return view('laporan.absensi.index', compact('absensi'));
    }

    public function exportPdf(Request $request)
    {
        $absensi = $this->getData($request);

        $pdf = Pdf::loadView('laporan.absensi.pdf', compact('absensi'));
        return $pdf->download('laporan-absensi.pdf');
    }

    public function exportExcel(Request $request)
    {
        return \Excel::download(
            new \App\Exports\AbsensiExport($request),
            'laporan-absensi.xlsx'
        );
    }

    private function getData(Request $request)
    {
        $query = Absensi::with(['karyawan', 'shift']);

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal', [
                $request->tanggal_mulai,
                $request->tanggal_selesai,
            ]);
        }

        if ($request->filled('karyawan_id')) {
            $query->where('karyawan_id', $request->karyawan_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return $query->orderBy('tanggal', 'desc')->get();
    }
}