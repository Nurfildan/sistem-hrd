@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit"></i> Edit Data User
        </h1>
        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-icon-split shadow-sm">
            <span class="icon text-white-50">
                <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user-edit"></i> Form Edit User
                    </h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Karyawan -->
                        <div class="form-group">
                            <label class="font-weight-bold">Karyawan</label>
                            <select name="karyawan_id" class="form-control">
                                <option value="">-- Tanpa Karyawan --</option>
                                @foreach($karyawan as $k)
                                    <option value="{{ $k->id }}"
                                        {{ $user->karyawan_id == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nama -->
                        <div class="form-group">
                            <label for="name" class="font-weight-bold">Nama User</label>
                            <input type="text"
                                   class="form-control"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $user->name) }}"
                                   required>
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label class="font-weight-bold">Email</label>
                            <input type="email"
                                   class="form-control"
                                   name="email"
                                   value="{{ old('email', $user->email) }}"
                                   required>
                        </div>

                        <!-- Role -->
                        <div class="form-group">
                            <label class="font-weight-bold">Role</label>
                            <select name="role" class="form-control" required>
                                <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                                <option value="HRD" {{ $user->role == 'HRD' ? 'selected' : '' }}>HRD</option>
                                <option value="Karyawan" {{ $user->role == 'Karyawan' ? 'selected' : '' }}>Karyawan</option>
                            </select>
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label class="font-weight-bold">Password (Opsional)</label>
                            <input type="password"
                                   class="form-control"
                                   name="password"
                                   placeholder="Kosongkan jika tidak ingin mengubah password">
                        </div>

                        <hr class="my-4">

                        <!-- Info Update -->
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Terakhir diupdate:</strong> 
                            {{ $user->updated_at->format('d/m/Y H:i') }} WIB
                        </div>

                        <!-- Actions -->
                        <div class="form-group text-right">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="reset" class="btn btn-warning">
                                <i class="fas fa-redo"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Update Data
                            </button>
                        </div>

                    </form>
                </div>
            </div>
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

    .card { border-radius: 10px; }

    .form-control {
        border-radius: 8px;
    }

    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78,115,223,0.15);
    }

    label {
        color: #5a5c69;
        font-size: 0.9rem;
    }

    .alert {
        border-radius: 8px;
        border: none;
    }
</style>
@endsection
