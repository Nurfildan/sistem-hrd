<?php

namespace App\Http\Controllers;

use App\Models\Penggajian;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanPenggajianController extends Controller
{
    public function index(Request $request)
    {
        $penggajian = $this->getData($request);

        return view('laporan.penggajian.index', compact('penggajian'));
    }

    public function exportPdf(Request $request)
    {
        $penggajian = $this->getData($request);

        $pdf = Pdf::loadView('laporan.penggajian.pdf', compact('penggajian'));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('laporan-penggajian.pdf');
    }

    public function exportExcel(Request $request)
    {
        return \Excel::download(
            new \App\Exports\PenggajianExport($request),
            'laporan-penggajian.xlsx'
        );
    }

    private function getData(Request $request)
    {
        $query = Penggajian::with(['karyawan', 'potongan']);

        if ($request->filled('periode')) {
            $query->where('periode', $request->periode);
        }

        if ($request->filled('karyawan_id')) {
            $query->where('karyawan_id', $request->karyawan_id);
        }

        if ($request->filled('status_pembayaran')) {
            $query->where('status_pembayaran', $request->status_pembayaran);
        }

        return $query->orderBy('tanggal_penggajian', 'desc')->get();
    }
}