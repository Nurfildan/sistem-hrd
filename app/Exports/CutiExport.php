<?php

namespace App\Exports;

use App\Models\Cuti;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class CutiExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, WithColumnWidths
{
    protected $request;

    public function __construct(Request $request = null)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Cuti::with(['karyawan', 'approver']);

        if ($this->request && $this->request->filled('status')) {
            $query->where('status', $this->request->status);
        }

        if ($this->request && $this->request->filled('karyawan_id')) {
            $query->where('karyawan_id', $this->request->karyawan_id);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Karyawan',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Durasi (Hari)',
            'Keterangan',
            'Status',
            'Disetujui Oleh',
            'Tanggal Disetujui',
            'Tanggal Diajukan',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        $durasi = 0;
        if ($row->tanggal_mulai && $row->tanggal_selesai) {
            $durasi = $row->tanggal_mulai->diffInDays($row->tanggal_selesai) + 1;
        }

        return [
            $no,
            $row->karyawan->nama ?? '-',
            $row->tanggal_mulai ? $row->tanggal_mulai->format('d/m/Y') : '-',
            $row->tanggal_selesai ? $row->tanggal_selesai->format('d/m/Y') : '-',
            $durasi,
            $row->keterangan ?? '-',
            $row->status ?? '-',
            ($row->status == 'Disetujui' && $row->approver) ? $row->approver->name : '-',
            ($row->status == 'Disetujui' && $row->approved_at) ? $row->approved_at->format('d/m/Y H:i') : '-',
            $row->created_at->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            // Header row
            1 => [
                'font' => [
                    'bold'  => true,
                    'color' => ['argb' => 'FFFFFFFF'],
                    'size'  => 11,
                ],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF4E73DF'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 25,
            'C' => 16,
            'D' => 16,
            'E' => 14,
            'F' => 35,
            'G' => 12,
            'H' => 20,
            'I' => 18,
            'J' => 18,
        ];
    }

    public function title(): string
    {
        return 'Laporan Cuti';
    }
}