@extends('layouts.app', ['title' => 'Profil Saya'])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-id-card"></i> Profil Saya</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Pengaturan</div>
                    <div class="breadcrumb-item">Profil</div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Informasi Akun</h4>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}" class="rounded-circle" width="80">
                                <h5 class="mt-3 mb-0 font-weight-bold">{{ $user->name }}</h5>
                                <span class="badge badge-primary">{{ ucfirst($user->role) }}</span>
                            </div>

                            <form method="POST" action="{{ route('admin.profile.update') }}">
                                @csrf
                                <div class="form-group">
                                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Username <span class="text-danger">*</span></label>
                                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                                                value="{{ old('username', $user->username) }}" required>
                                            @error('username')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email', $user->email) }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>No. HP</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" maxlength="30">
                                </div>
                                <hr>
                                <h6 class="font-weight-bold">Ganti Password <small class="text-muted">(opsional)</small></h6>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Password Baru</label>
                                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                                minlength="6" placeholder="Kosongkan jika tidak diganti">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
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
                                <button type="submit" class="btn btn-primary font-weight-bold" style="background: linear-gradient(135deg, #123E73, #1E5AA8); border: none;">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection