@extends('layouts.app')

@section('title', 'Data Cuti')

@section('content')
<div class="container-fluid">

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">×</button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">×</button>
        </div>
    @endif

    <div class="card shadow mb-4">

        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                @if(Auth::user()->role === 'Karyawan')
                    Pengajuan Cuti Saya
                @else
                    Data Cuti Karyawan
                @endif
            </h6>

            @if(Auth::user()->role === 'Karyawan')
                <a href="{{ route('cuti.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Ajukan Cuti
                </a>
            @endif
        </div>

        <div class="card-body">

            {{-- FILTER UNTUK HRD --}}
            @if(Auth::user()->role === 'HRD')
                <div class="mb-3 p-3 bg-light rounded">
                    <form method="GET" action="{{ route('cuti.index') }}">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Karyawan</label>
                                <select name="karyawan_id" class="form-control">
                                    <option value="">Semua Karyawan</option>
                                    @foreach($karyawanList as $k)
                                        <option value="{{ $k->id }}" 
                                            {{ request('karyawan_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama }} ({{ $k->nip }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="">Semua Status</option>
                                    <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>

                            <div class="col-md-3 d-flex align-items-end">
                                <button class="btn btn-primary mr-2">
                                    <i class="fas fa-search"></i>
                                </button>
                                <a href="{{ route('cuti.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-redo"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            @endif

            {{-- TABEL --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>No</th>
                            @if(Auth::user()->role === 'HRD') <th>Karyawan</th> @endif
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Durasi</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th width="150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cuti as $i => $c)
                        <tr>
                            <td>{{ $cuti->firstItem() + $i }}</td>

                            @if(Auth::user()->role === 'HRD')
                                <td>{{ $c->karyawan->nama ?? '-' }}</td>
                            @endif

                            <td>{{ \Carbon\Carbon::parse($c->tanggal_mulai)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($c->tanggal_selesai)->format('d M Y') }}</td>

                            <td>
                                {{ \Carbon\Carbon::parse($c->tanggal_mulai)->diffInDays($c->tanggal_selesai) + 1 }} hari
                            </td>

                            <td>{{ Str::limit($c->keterangan, 40) }}</td>

                            <td>
                                @if($c->status == 'Menunggu')
                                    <span class="badge badge-warning">{{ $c->status }}</span>
                                @elseif($c->status == 'Disetujui')
                                    <span class="badge badge-success">{{ $c->status }}</span>
                                @else
                                    <span class="badge badge-danger">{{ $c->status }}</span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('cuti.show', $c->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @if(Auth::user()->role === 'HRD')

                                    @if($c->status == 'Menunggu')
                                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalApprove{{ $c->id }}">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                    @endif

                                    <a href="{{ route('cuti.edit', $c->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('cuti.destroy', $c->id) }}" class="d-inline" method="POST">
                                        @csrf @method('DELETE')
                                        <button onclick="return confirm('Yakin hapus?')" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                @endif
                            </td>
                        </tr>

                        {{-- MODAL APPROVAL --}}
                        @if(Auth::user()->role === 'HRD')
                        <div class="modal fade" id="modalApprove{{ $c->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Approval Cuti</h5>
                                        <button class="close" data-dismiss="modal">×</button>
                                    </div>

                                    <form action="{{ route('cuti.updateStatus', $c->id) }}" method="POST">
                                        @csrf @method('PATCH')

                                        <div class="modal-body">
                                            <p><b>Karyawan:</b> {{ $c->karyawan->nama }}</p>
                                            <p><b>Tanggal:</b> {{ $c->tanggal_mulai }} - {{ $c->tanggal_selesai }}</p>
                                            <p><b>Keterangan:</b> {{ $c->keterangan }}</p>

                                            <label>Keputusan</label>
                                            <select name="status" required class="form-control">
                                                <option value="">-- pilih --</option>
                                                <option value="Disetujui">Disetujui</option>
                                                <option value="Ditolak">Ditolak</option>
                                            </select>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        @endif

                        @empty
                            <tr>
                                <td colspan="{{ Auth::user()->role === 'HRD' ? 8 : 7 }}" class="text-center text-muted">
                                    Tidak ada data
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="d-flex justify-content-center">
                {{ $cuti->links() }}
            </div>

        </div>
    </div>

</div>
@endsection
