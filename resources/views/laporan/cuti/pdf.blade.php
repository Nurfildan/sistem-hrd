<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Cuti</title>
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
            font-size: 10px;
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
        .badge-warning  { background-color: #f6c23e; color: #333; }
        .badge-danger   { background-color: #e74a3b; }
        .badge-info     { background-color: #36b9cc; }
        .footer {
            margin-top: 20px;
            font-size: 9px;
            color: #aaa;
            text-align: right;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <h2>Laporan Pengajuan Cuti Karyawan</h2>
        <p>Dicetak pada: {{ now()->format('d M Y, H:i') }} WIB</p>
    </div>

    {{-- Summary --}}
    <div class="summary">
        <div class="summary-box">
            <div class="num">{{ $cuti->count() }}</div>
            <div class="label">Total Pengajuan</div>
        </div>
        <div class="summary-box">
            <div class="num" style="color:#f6c23e">{{ $cuti->where('status','Menunggu')->count() }}</div>
            <div class="label">Menunggu</div>
        </div>
        <div class="summary-box">
            <div class="num" style="color:#1cc88a">{{ $cuti->where('status','Disetujui')->count() }}</div>
            <div class="label">Disetujui</div>
        </div>
        <div class="summary-box">
            <div class="num" style="color:#e74a3b">{{ $cuti->where('status','Ditolak')->count() }}</div>
            <div class="label">Ditolak</div>
        </div>
    </div>

    {{-- Tabel --}}
    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="18%">Karyawan</th>
                <th width="12%">Tanggal Mulai</th>
                <th width="12%">Tanggal Selesai</th>
                <th width="8%">Durasi</th>
                <th width="22%">Keterangan</th>
                <th width="12%">Status</th>
                <th width="12%">Disetujui Oleh</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cuti as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->karyawan->nama ?? '-' }}</td>
                <td class="text-center">
                    {{ $item->tanggal_mulai ? $item->tanggal_mulai->format('d/m/Y') : '-' }}
                </td>
                <td class="text-center">
                    {{ $item->tanggal_selesai ? $item->tanggal_selesai->format('d/m/Y') : '-' }}
                </td>
                <td class="text-center">
                    @if($item->tanggal_mulai && $item->tanggal_selesai)
                        {{ $item->tanggal_mulai->diffInDays($item->tanggal_selesai) + 1 }} hari
                    @else
                        -
                    @endif
                </td>
                <td style="font-size: 9px;">{{ $item->keterangan ?? '-' }}</td>
                <td class="text-center">
                    @php
                        $statusMap = [
                            'Menunggu'  => ['warning', 'Menunggu'],
                            'Disetujui' => ['success', 'Disetujui'],
                            'Ditolak'   => ['danger',  'Ditolak'],
                        ];
                        $s = $statusMap[$item->status] ?? ['info', $item->status];
                    @endphp
                    <span class="badge badge-{{ $s[0] }}">{{ $s[1] }}</span>
                </td>
                <td class="text-center" style="font-size: 9px;">
                    @if($item->status == 'Disetujui' && $item->approver)
                        {{ $item->approver->name }}<br>
                        {{ $item->approved_at ? $item->approved_at->format('d/m/Y') : '' }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center" style="padding: 20px; color: #aaa;">
                    Tidak ada data pengajuan cuti
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Total {{ $cuti->count() }} data &mdash; Laporan ini digenerate otomatis oleh sistem
    </div>

</body>
</html>