<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanCutiController extends Controller
{
    public function index(Request $request)
    {
        $cuti = $this->getData($request);

        return view('laporan.cuti.index', compact('cuti'));
    }

    public function exportPdf(Request $request)
    {
        $cuti = $this->getData($request);

        $pdf = Pdf::loadView('laporan.cuti.pdf', compact('cuti'));
        return $pdf->download('laporan-cuti.pdf');
    }

    public function exportExcel(Request $request)
    {
        return \Excel::download(
            new \App\Exports\CutiExport($request),
            'laporan-cuti.xlsx'
        );
    }

    private function getData(Request $request)
    {
        $query = Cuti::with(['karyawan', 'approver']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('karyawan_id')) {
            $query->where('karyawan_id', $request->karyawan_id);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }
}