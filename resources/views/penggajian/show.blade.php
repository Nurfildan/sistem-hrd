@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card shadow">

                    <!-- HEADER -->
                    <div class="card-header text-center bg-primary text-white">
                        <h4 class="mb-0">SLIP GAJI KARYAWAN</h4>
                        <small>
                            Periode:
                            {{ \Carbon\Carbon::parse($penggajian->periode)->translatedFormat('F Y') }}
                        </small>
                    </div>

                    <div class="card-body">

                        <!-- IDENTITAS -->
                        <table class="table table-borderless mb-4">
                            <tr>
                                <td width="30%">Nama Karyawan</td>
                                <td>: <strong>{{ $penggajian->karyawan->nama }}</strong></td>
                            </tr>
                            <tr>
                                <td>Jabatan</td>
                                <td>: {{ $penggajian->karyawan->jabatan->nama_jabatan }}</td>
                            </tr>
                            <tr>
                                <td>Status Pembayaran</td>
                                <td>:
                                    @if($penggajian->status_pembayaran == 'Sudah Dibayar')
                                        <span class="badge badge-success">Sudah Dibayar</span>
                                    @else
                                        <span class="badge badge-warning text-dark">Belum Dibayar</span>
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <hr>

                        <!-- RINCIAN GAJI -->
                        <table class="table table-bordered">
                            <tr>
                                <th>Gaji Pokok</th>
                                <td class="text-right">
                                    Rp {{ number_format($penggajian->gaji_pokok, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <th>Tunjangan</th>
                                <td class="text-right">
                                    Rp {{ number_format($penggajian->tunjangan, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <th class="text-danger">Potongan Otomatis</th>
                                <td class="text-right text-danger">
                                    Rp {{ number_format($penggajian->potongan_otomatis, 0, ',', '.') }}
                                </td>
                            </tr>

                            @if($penggajian->potongan_tambahan > 0)
                                <tr>
                                    <th class="text-danger">Potongan Tambahan</th>
                                    <td class="text-right text-danger">
                                        Rp {{ number_format($penggajian->potongan_tambahan, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endif

                            <tr>
                                <th class="text-danger">Total Potongan</th>
                                <td class="text-right text-danger">
                                    Rp
                                    {{ number_format($penggajian->potongan_otomatis + $penggajian->potongan_tambahan, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr class="table-primary">
                                <th>Total Gaji Diterima</th>
                                <th class="text-right">
                                    Rp {{ number_format($penggajian->total_gaji, 0, ',', '.') }}
                                </th>
                            </tr>
                        </table>

                        <!-- FOOTER -->
                        <div class="d-flex justify-content-between mt-4">
                            <small class="text-muted">
                                Dicetak pada: {{ now()->translatedFormat('d F Y') }}
                            </small>

                            <div>
                                <a href="{{ route('penggajian.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>

                                <button onclick="window.print()" class="btn btn-primary btn-sm">
                                    <i class="fas fa-print"></i> Cetak Slip
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .card,
            .card * {
                visibility: visible;
            }

            .card {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
    </style>
@endsection