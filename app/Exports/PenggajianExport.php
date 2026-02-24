<?php

namespace App\Exports;

use App\Models\Penggajian;
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
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PenggajianExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, WithColumnWidths
{
    protected $request;

    public function __construct(Request $request = null)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Penggajian::with(['karyawan', 'potongan']);

        if ($this->request && $this->request->filled('periode')) {
            $query->where('periode', $this->request->periode);
        }

        if ($this->request && $this->request->filled('karyawan_id')) {
            $query->where('karyawan_id', $this->request->karyawan_id);
        }

        if ($this->request && $this->request->filled('status_pembayaran')) {
            $query->where('status_pembayaran', $this->request->status_pembayaran);
        }

        return $query->orderBy('tanggal_penggajian', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Karyawan',
            'Jabatan',
            'Periode',
            'Tanggal Penggajian',
            'Gaji Pokok',
            'Tunjangan',
            'Potongan Otomatis',
            'Potongan Manual',
            'Total Gaji',
            'Status Pembayaran',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $row->nama_karyawan ?? $row->karyawan->nama ?? '-',
            $row->nama_jabatan ?? '-',
            $row->periode ? \Carbon\Carbon::parse($row->periode . '-01')->format('M Y') : '-',
            $row->tanggal_penggajian ? $row->tanggal_penggajian->format('d/m/Y') : '-',
            $row->gaji_pokok,
            $row->tunjangan,
            $row->potongan_otomatis,
            $row->potongan->sum('jumlah'),
            $row->total_gaji,
            $row->status_pembayaran ?? '-',
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
            'C' => 20,
            'D' => 12,
            'E' => 18,
            'F' => 16,
            'G' => 14,
            'H' => 18,
            'I' => 18,
            'J' => 16,
            'K' => 18,
        ];
    }

    public function title(): string
    {
        return 'Laporan Penggajian';
    }
}