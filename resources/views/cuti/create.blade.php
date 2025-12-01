@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Ajukan Cuti Baru</h4>
                </div>
                <div class="card-body">
                    
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('cuti.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_mulai" 
                                   class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                   value="{{ old('tanggal_mulai') }}" 
                                   min="{{ date('Y-m-d') }}"
                                   required>
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_selesai" 
                                   class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                   value="{{ old('tanggal_selesai') }}" 
                                   min="{{ date('Y-m-d') }}"
                                   required>
                            @error('tanggal_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Keterangan/Alasan Cuti <span class="text-danger">*</span></label>
                            <textarea name="keterangan" rows="4" 
                                      class="form-control @error('keterangan') is-invalid @enderror" 
                                      placeholder="Tuliskan alasan pengajuan cuti..."
                                      required>{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Maksimal 500 karakter</small>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('cuti.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Ajukan Cuti
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection