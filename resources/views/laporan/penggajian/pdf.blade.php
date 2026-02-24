<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penggajian</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #4e73df;
            padding-bottom: 10px;
            margin-bottom: 16px;
        }
        .header h2 {
            font-size: 16px;
            font-weight: bold;
            color: #4e73df;
            margin-bottom: 2px;
        }
        .header p {
            font-size: 10px;
            color: #666;
        }
        .summary {
            display: table;
            width: 100%;
            margin-bottom: 14px;
        }
        .summary-box {
            display: table-cell;
            width: 25%;
            text-align: center;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .summary-box .num {
            font-size: 14px;
            font-weight: bold;
            color: #4e73df;
        }
        .summary-box .label {
            font-size: 8px;
            color: #888;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        thead th {
            background-color: #4e73df;
            color: #fff;
            text-align: center;
            padding: 6px 4px;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border: 1px solid #3a5fc8;
        }
        tbody td {
            padding: 4px;
            border: 1px solid #ddd;
            vertical-align: middle;
            font-size: 9px;
        }
        tfoot th {
            padding: 6px 4px;
            border: 1px solid #ddd;
            background-color: #f8f9fc;
            font-weight: bold;
            font-size: 9px;
        }
        tbody tr:nth-child(even) {
            background-color: #f8f9fc;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 8px;
            font-weight: bold;
            color: #fff;
        }
        .badge-success  { background-color: #1cc88a; }
        .badge-warning  { background-color: #f6c23e; color: #333; }
        .badge-secondary{ background-color: #858796; }
        .footer {
            margin-top: 20px;
            font-size: 8px;
            color: #aaa;
            text-align: right;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <h2>Laporan Penggajian Karyawan</h2>
        <p>Dicetak pada: {{ now()->format('d M Y, H:i') }} WIB</p>
    </div>

    {{-- Summary --}}
    <div class="summary">
        <div class="summary-box">
            <div class="num">{{ $penggajian->count() }}</div>
            <div class="label">Total Data</div>
        </div>
        <div class="summary-box">
            <div class="num" style="color:#1cc88a">Rp {{ number_format($penggajian->where('status_pembayaran','Sudah Dibayar')->sum('total_gaji')/1000000, 1) }}jt</div>
            <div class="label">Sudah Dibayar</div>
        </div>
        <div class="summary-box">
            <div class="num" style="color:#f6c23e">Rp {{ number_format($penggajian->where('status_pembayaran','Belum Dibayar')->sum('total_gaji')/1000000, 1) }}jt</div>
            <div class="label">Belum Dibayar</div>
        </div>
        <div class="summary-box">
            <div class="num" style="color:#36b9cc">Rp {{ number_format($penggajian->sum('total_gaji')/1000000, 1) }}jt</div>
            <div class="label">Total</div>
        </div>
    </div>

    {{-- Tabel --}}
    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="18%">Karyawan</th>
                <th width="12%">Jabatan</th>
                <th width="8%">Periode</th>
                <th width="10%">Tgl Gajian</th>
                <th width="12%">Gaji Pokok</th>
                <th width="11%">Tunjangan</th>
                <th width="11%">Potongan</th>
                <th width="12%">Total</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penggajian as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->nama_karyawan ?? $item->karyawan->nama ?? '-' }}</td>
                <td>{{ $item->nama_jabatan ?? '-' }}</td>
                <td class="text-center">
                    {{ $item->periode ? \Carbon\Carbon::parse($item->periode . '-01')->format('M Y') : '-' }}
                </td>
                <td class="text-center">
                    {{ $item->tanggal_penggajian ? $item->tanggal_penggajian->format('d/m/Y') : '-' }}
                </td>
                <td class="text-right">{{ number_format($item->gaji_pokok, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($item->tunjangan, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($item->potongan_otomatis + $item->potongan->sum('jumlah'), 0, ',', '.') }}</td>
                <td class="text-right"><strong>{{ number_format($item->total_gaji, 0, ',', '.') }}</strong></td>
                <td class="text-center">
                    @php
                        $statusMap = [
                            'Belum Dibayar' => ['warning', 'Belum'],
                            'Sudah Dibayar' => ['success', 'Lunas'],
                        ];
                        $s = $statusMap[$item->status_pembayaran] ?? ['secondary', $item->status_pembayaran];
                    @endphp
                    <span class="badge badge-{{ $s[0] }}">{{ $s[1] }}</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center" style="padding: 20px; color: #aaa;">
                    Tidak ada data penggajian
                </td>
            </tr>
            @endforelse
        </tbody>
        @if($penggajian->count() > 0)
        <tfoot>
            <tr>
                <th colspan="5" class="text-right">TOTAL:</th>
                <th class="text-right">{{ number_format($penggajian->sum('gaji_pokok'), 0, ',', '.') }}</th>
                <th class="text-right">{{ number_format($penggajian->sum('tunjangan'), 0, ',', '.') }}</th>
                <th class="text-right">{{ number_format($penggajian->sum('potongan_otomatis') + $penggajian->sum(function($item) { return $item->potongan->sum('jumlah'); }), 0, ',', '.') }}</th>
                <th class="text-right"><strong>{{ number_format($penggajian->sum('total_gaji'), 0, ',', '.') }}</strong></th>
                <th></th>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="footer">
        Total {{ $penggajian->count() }} data &mdash; Laporan ini digenerate otomatis oleh sistem
    </div>

</body>
</html>