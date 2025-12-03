@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-edit"></i> Edit Profil
        </h1>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> <strong>Terjadi Kesalahan!</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-edit"></i> Form Edit Profil
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!-- Preview Foto -->
                <div class="text-center mb-4">
                    <div class="profile-image-wrapper">
                        <img src="{{ $karyawan->foto ? asset('foto_karyawan/'.$karyawan->foto) : asset('img/default-avatar.png') }}" 
                             class="rounded-circle border shadow-sm" 
                             width="150" 
                             height="150" 
                             style="object-fit: cover;" 
                             id="preview-foto">
                    </div>
                    <p class="text-muted small mt-2">
                        <i class="fas fa-info-circle"></i> Klik "Ganti Foto" di bawah untuk mengubah foto profil
                    </p>
                </div>

                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-id-card text-primary"></i> NIP</label>
                            <input type="text" class="form-control" value="{{ $karyawan->nip }}" readonly>
                            <small class="form-text text-muted">NIP tidak dapat diubah</small>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-user text-primary"></i> Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="nama" 
                                   class="form-control @error('nama') is-invalid @enderror" 
                                   value="{{ old('nama', $karyawan->nama) }}" 
                                   required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-briefcase text-primary"></i> Jabatan</label>
                            <input type="text" class="form-control" value="{{ $karyawan->jabatan->nama_jabatan }}" readonly>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-building text-primary"></i> Departemen</label>
                            <input type="text" class="form-control" value="{{ $karyawan->departemen->nama_departemen }}" readonly>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-phone text-primary"></i> No. HP</label>
                            <input type="text" 
                                   name="no_hp" 
                                   class="form-control @error('no_hp') is-invalid @enderror" 
                                   value="{{ old('no_hp', $karyawan->no_hp) }}"
                                   placeholder="Contoh: 08123456789">
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-envelope text-primary"></i> Email</label>
                            <input type="email" 
                                   name="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $karyawan->email) }}"
                                   placeholder="contoh@email.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-map-marker-alt text-primary"></i> Alamat</label>
                            <textarea name="alamat" 
                                      class="form-control @error('alamat') is-invalid @enderror" 
                                      rows="4"
                                      placeholder="Masukkan alamat lengkap">{{ old('alamat', $karyawan->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Upload Foto -->
                <div class="form-group">
                    <label><i class="fas fa-camera text-primary"></i> Ganti Foto</label>
                    <div class="custom-file">
                        <input type="file" 
                               name="foto" 
                               class="custom-file-input @error('foto') is-invalid @enderror" 
                               id="customFile"
                               accept="image/*" 
                               onchange="previewImage(event)">
                        <label class="custom-file-label" for="customFile">Pilih foto...</label>
                    </div>
                    <small class="form-text text-muted">
                        <i class="fas fa-info-circle"></i> Format: JPG, JPEG, PNG. Maksimal 2MB
                    </small>
                    @error('foto')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="my-4">

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-between">
                    <a href="{{ route('profile.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .btn-icon-split {
        border-radius: 10rem;
        overflow: hidden;
    }

    .btn-icon-split .icon {
        padding: 0.75rem;
        display: inline-flex;
        align-items: center;
    }

    .btn-icon-split .text {
        padding: 0.75rem 1.25rem;
    }

    .alert {
        border-radius: 10px;
        border: none;
    }

    .card {
        border-radius: 10px;
        border: none;
    }

    .card-header {
        background-color: #f8f9fc;
        border-bottom: 2px solid #4e73df;
        border-radius: 10px 10px 0 0 !important;
    }

    .form-control {
        border-radius: 5px;
        border: 1px solid #d1d3e2;
    }

    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    .custom-file-label {
        border-radius: 5px;
    }

    .profile-image-wrapper {
        position: relative;
        display: inline-block;
    }

    label i {
        margin-right: 5px;
    }

    .btn {
        border-radius: 5px;
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
    }
</style>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const preview = document.getElementById('preview-foto');
        preview.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
    
    // Update label custom file
    const fileName = event.target.files[0].name;
    const label = event.target.nextElementSibling;
    label.innerText = fileName;
}
</script>
@endsection