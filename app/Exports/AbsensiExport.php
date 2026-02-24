<?php

namespace App\Exports;

use App\Models\Absensi;
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

class AbsensiExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, WithColumnWidths
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Absensi::with(['karyawan', 'shift']);

        if ($this->request->filled('tanggal_mulai') && $this->request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal', [
                $this->request->tanggal_mulai,
                $this->request->tanggal_selesai,
            ]);
        }

        if ($this->request->filled('karyawan_id')) {
            $query->where('karyawan_id', $this->request->karyawan_id);
        }

        if ($this->request->filled('status')) {
            $query->where('status', $this->request->status);
        }

        return $query->orderBy('tanggal', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Karyawan',
            'Tanggal',
            'Shift',
            'Jam Masuk',
            'Jam Keluar',
            'Status',
            'Terlambat (Menit)',
            'Sumber',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $row->karyawan->nama ?? '-',
            $row->tanggal ? $row->tanggal->format('d/m/Y') : '-',
            $row->shift->nama ?? '-',
            $row->jam_masuk  ? $row->jam_masuk->format('H:i')  : '-',
            $row->jam_keluar ? $row->jam_keluar->format('H:i') : '-',
            ucfirst($row->status ?? '-'),
            $row->terlambat_menit ?? 0,
            ucfirst($row->sumber ?? '-'),
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
            'C' => 14,
            'D' => 18,
            'E' => 12,
            'F' => 12,
            'G' => 12,
            'H' => 18,
            'I' => 14,
        ];
    }

    public function title(): string
    {
        return 'Laporan Absensi';
    }
}