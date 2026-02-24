<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
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
        .meta {
            margin-bottom: 12px;
            font-size: 10px;
            color: #555;
        }
        .meta span {
            margin-right: 20px;
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
            padding: 6px 8px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            border: 1px solid #3a5fc8;
        }
        tbody td {
            padding: 5px 8px;
            border: 1px solid #ddd;
            vertical-align: middle;
        }
        tbody tr:nth-child(even) {
            background-color: #f8f9fc;
        }
        .text-center { text-align: center; }
        .badge {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
            color: #fff;
        }
        .badge-success  { background-color: #1cc88a; }
        .badge-info     { background-color: #36b9cc; }
        .badge-warning  { background-color: #f6c23e; color: #333; }
        .badge-danger   { background-color: #e74a3b; }
        .badge-primary  { background-color: #4e73df; }
        .badge-secondary{ background-color: #858796; }
        .footer {
            margin-top: 20px;
            font-size: 9px;
            color: #aaa;
            text-align: right;
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
            font-size: 18px;
            font-weight: bold;
            color: #4e73df;
        }
        .summary-box .label {
            font-size: 9px;
            color: #888;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <h2>Laporan Absensi Karyawan</h2>
        <p>Dicetak pada: {{ now()->format('d M Y, H:i') }} WIB</p>
    </div>

    {{-- Summary --}}
    <div class="summary">
        <div class="summary-box">
            <div class="num">{{ $absensi->count() }}</div>
            <div class="label">Total</div>
        </div>
        <div class="summary-box">
            <div class="num" style="color:#1cc88a">{{ $absensi->where('status','hadir')->count() }}</div>
            <div class="label">Hadir</div>
        </div>
        <div class="summary-box">
            <div class="num" style="color:#f6c23e">{{ $absensi->whereIn('status',['izin','sakit'])->count() }}</div>
            <div class="label">Izin / Sakit</div>
        </div>
        <div class="summary-box">
            <div class="num" style="color:#e74a3b">{{ $absensi->where('status','alpha')->count() }}</div>
            <div class="label">Alpha</div>
        </div>
    </div>

    {{-- Tabel --}}
    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="18%">Karyawan</th>
                <th width="11%">Tanggal</th>
                <th width="12%">Shift</th>
                <th width="9%">Jam Masuk</th>
                <th width="9%">Jam Keluar</th>
                <th width="10%">Status</th>
                <th width="10%">Terlambat</th>
                <th width="10%">Sumber</th>
            </tr>
        </thead>
        <tbody>
            @forelse($absensi as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->karyawan->nama ?? '-' }}</td>
                <td class="text-center">
                    {{ $item->tanggal ? $item->tanggal->format('d/m/Y') : '-' }}
                </td>
                <td class="text-center">{{ $item->shift->nama ?? '-' }}</td>
                <td class="text-center">
                    {{ $item->jam_masuk ? $item->jam_masuk->format('H:i') : '-' }}
                </td>
                <td class="text-center">
                    {{ $item->jam_keluar ? $item->jam_keluar->format('H:i') : '-' }}
                </td>
                <td class="text-center">
                    @php
                        $statusMap = [
                            'hadir' => ['success', 'Hadir'],
                            'izin'  => ['info',    'Izin'],
                            'sakit' => ['warning', 'Sakit'],
                            'alpha' => ['danger',  'Alpha'],
                            'cuti'  => ['primary', 'Cuti'],
                        ];
                        $s = $statusMap[$item->status] ?? ['secondary', ucfirst($item->status)];
                    @endphp
                    <span class="badge badge-{{ $s[0] }}">{{ $s[1] }}</span>
                </td>
                <td class="text-center">
                    {{ $item->terlambat_menit > 0 ? $item->terlambat_menit . ' mnt' : '-' }}
                </td>
                <td class="text-center">{{ $item->sumber ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center" style="padding: 20px; color: #aaa;">
                    Tidak ada data absensi
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Total {{ $absensi->count() }} data &mdash; Laporan ini digenerate otomatis oleh sistem
    </div>

</body>
</html>