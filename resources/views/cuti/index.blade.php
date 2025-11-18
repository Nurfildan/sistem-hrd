@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            {{-- Alert Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        @if(Auth::user()->role === 'Karyawan')
                            Pengajuan Cuti Saya
                        @else
                            Data Cuti Karyawan
                        @endif
                    </h4>
                    
                    @if(Auth::user()->role === 'Karyawan')
                        <a href="{{ route('cuti.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Ajukan Cuti
                        </a>
                    @endif
                </div>

                <div class="card-body">

                    {{-- FILTER UNTUK HRD --}}
                    @if(Auth::user()->role === 'HRD')
                        <div class="card mb-3 bg-light">
                            <div class="card-body">
                                <form method="GET" action="{{ route('cuti.index') }}">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Karyawan</label>
                                            <select name="karyawan_id" class="form-select">
                                                <option value="">Semua Karyawan</option>
                                                @foreach($karyawanList as $k)
                                                    <option value="{{ $k->id }}" {{ request('karyawan_id') == $k->id ? 'selected' : '' }}>
                                                        {{ $k->nama }} ({{ $k->nip }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-select">
                                                <option value="">Semua Status</option>
                                                <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                                <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                                <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">&nbsp;</label>
                                            <div>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-search"></i> Filter
                                                </button>
                                                <a href="{{ route('cuti.index') }}" class="btn btn-secondary">
                                                    <i class="fas fa-redo"></i> Reset
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif

                    {{-- TABEL DATA CUTI --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    @if(Auth::user()->role === 'HRD')
                                        <th>Karyawan</th>
                                    @endif
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Durasi</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cuti as $index => $c)
                                    <tr>
                                        <td>{{ $cuti->firstItem() + $index }}</td>
                                        @if(Auth::user()->role === 'HRD')
                                            <td>{{ $c->karyawan->nama ?? '-' }}</td>
                                        @endif
                                        <td>{{ \Carbon\Carbon::parse($c->tanggal_mulai)->locale('id')->translatedFormat('d M Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($c->tanggal_selesai)->locale('id')->translatedFormat('d M Y') }}</td>
                                        <td>
                                            @php
                                                $durasi = \Carbon\Carbon::parse($c->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($c->tanggal_selesai)) + 1;
                                            @endphp
                                            {{ $durasi }} hari
                                        </td>
                                        <td>{{ Str::limit($c->keterangan, 50) }}</td>
                                        <td>
                                            @if($c->status == 'Menunggu')
                                                <span class="badge bg-warning text-dark">{{ $c->status }}</span>
                                            @elseif($c->status == 'Disetujui')
                                                <span class="badge bg-success">{{ $c->status }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ $c->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('cuti.show', $c->id) }}" class="btn btn-sm btn-info" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if(Auth::user()->role === 'HRD')
                                                {{-- Tombol Approval (hanya untuk status Menunggu) --}}
                                                @if($c->status == 'Menunggu')
                                                    <button type="button" class="btn btn-sm btn-success" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#approvalModal{{ $c->id }}"
                                                            title="Setujui/Tolak">
                                                        <i class="fas fa-check-circle"></i>
                                                    </button>
                                                @endif

                                                <a href="{{ route('cuti.edit', $c->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <form action="{{ route('cuti.destroy', $c->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('Yakin ingin menghapus data cuti ini?')"
                                                            title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>

                                    {{-- MODAL APPROVAL (HRD Only) --}}
                                    @if(Auth::user()->role === 'HRD')
                                        <div class="modal fade" id="approvalModal{{ $c->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Approval Cuti</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{ route('cuti.updateStatus', $c->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="modal-body">
                                                            <p><strong>Karyawan:</strong> {{ $c->karyawan->nama }}</p>
                                                            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($c->tanggal_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($c->tanggal_selesai)->format('d/m/Y') }}</p>
                                                            <p><strong>Keterangan:</strong> {{ $c->keterangan }}</p>
                                                            <hr>
                                                            <div class="mb-3">
                                                                <label class="form-label">Keputusan <span class="text-danger">*</span></label>
                                                                <select name="status" class="form-select" required>
                                                                    <option value="">-- Pilih --</option>
                                                                    <option value="Disetujui">Disetujui</option>
                                                                    <option value="Ditolak">Ditolak</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan Keputusan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                @empty
                                    <tr>
                                        <td colspan="{{ Auth::user()->role === 'HRD' ? '8' : '7' }}" class="text-center py-4">
                                            <i class="fas fa-inbox" style="font-size: 2rem; color: #ccc;"></i>
                                            <p class="mb-0 mt-2 text-muted">
                                                @if(Auth::user()->role === 'Karyawan')
                                                    Belum ada pengajuan cuti
                                                @else
                                                    Tidak ada data cuti
                                                @endif
                                            </p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center mt-3">
                        {{ $cuti->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection