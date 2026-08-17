@extends('layouts.app', ['title' => 'Edit Akun'])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-user-edit"></i> Edit Akun</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Pengaturan</div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.akun.index') }}">Akun</a></div>
                    <div class="breadcrumb-item">Edit</div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Akun</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.akun.update', $data->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $data->name) }}" required maxlength="255">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Username <span class="text-danger">*</span></label>
                                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                                                value="{{ old('username', $data->username) }}" required maxlength="255">
                                            @error('username')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email', $data->email) }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>No. HP</label>
                                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $data->phone) }}" maxlength="30">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Role <span class="text-danger">*</span></label>
                                            <select name="role" class="form-control">
                                                <option value="customer" {{ old('role', $data->role) == 'customer' ? 'selected' : '' }}>Customer</option>
                                                <option value="admin" {{ old('role', $data->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Password <small class="text-muted">(opsional)</small></label>
                                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                                minlength="6" placeholder="Kosongkan jika tidak diganti">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Minimal 6 karakter</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Konfirmasi Password</label>
                                            <input type="password" name="password_confirmation" class="form-control" minlength="6"
                                                placeholder="Ulangi password baru">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #123E73, #1E5AA8); border: none;">
                                        <i class="fas fa-save"></i> Simpan Perubahan
                                    </button>
                                    <a href="{{ route('admin.akun.index') }}" class="btn btn-secondary">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection