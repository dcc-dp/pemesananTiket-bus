@extends('layouts.app', ['title' => 'Profil Saya', 'menu' => 'profile'])

@section('content')
    <div class="main-content">
        <section class="section">
            <!-- Page Header -->
            <div class="section-header">
                <div class="d-flex align-items-center">
                    <div class="header-icon-box mr-3">
                        <span class="material-symbols-outlined">person</span>
                    </div>
                    <div>
                        <h1 class="mb-0">Profil Saya</h1>
                        <div class="header-subtitle">Kelola informasi data diri, email akun, dan kata sandi administrator</div>
                    </div>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></div>
                    <div class="breadcrumb-item">Pengaturan</div>
                    <div class="breadcrumb-item active">Profil</div>
                </div>
            </div>

            <div class="row">
                <!-- Main Form Column -->
                <div class="col-lg-8 col-12 mb-4">
                    <div class="card">
                        <!-- Profile Card Header -->
                        <div class="p-4 border-bottom d-flex align-items-center gap-3">
                            <img alt="Avatar" src="{{ asset('img/avatar/avatar-1.png') }}" class="nav-user-avatar" style="width: 64px; height: 64px; border-radius: 16px;">
                            <div>
                                <h3 class="mb-1" style="font-size: 18px; font-weight: 800; color: #0f172a;">{{ $user->name }}</h3>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge badge-primary">{{ ucfirst($user->role) }}</span>
                                    <span class="text-muted small">&bull;</span>
                                    <span class="text-muted small">{{ $user->email ?? 'Super Admin' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Form Body -->
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.profile.update') }}">
                                @csrf

                                <h5 class="mb-3" style="font-size: 13px; font-weight: 700; color: #0f172a; text-transform: uppercase; letter-spacing: 0.05em;">
                                    Informasi Dasar
                                </h5>

                                <div class="form-group mb-3">
                                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mb-3">
                                            <label>Username <span class="text-danger">*</span></label>
                                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                                                value="{{ old('username', $user->username) }}" required>
                                            @error('username')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mb-3">
                                            <label>Email</label>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email', $user->email) }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label>Nomor Telepon / WhatsApp</label>
                                    <input type="text" name="phone" class="form-control"
                                        value="{{ old('phone', $user->phone) }}" maxlength="30" placeholder="Contoh: 081234567890">
                                </div>

                                <hr class="my-4" style="border-top-color: #f1f5f9;">

                                <h5 class="mb-3" style="font-size: 13px; font-weight: 700; color: #0f172a; text-transform: uppercase; letter-spacing: 0.05em;">
                                    Keamanan &amp; Kata Sandi <span class="text-muted font-weight-normal text-capitalize small">(opsional)</span>
                                </h5>

                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mb-3">
                                            <label>Password Baru</label>
                                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Kosongkan jika tidak diganti">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mb-3">
                                            <label>Konfirmasi Password</label>
                                            <input type="password" name="password_confirmation" class="form-control"
                                                placeholder="Ulangi password baru">
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center gap-2 mt-4 pt-2">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="material-symbols-outlined" style="font-size: 16px;">save</span>
                                        <span>Simpan Perubahan</span>
                                    </button>
                                    <button type="reset" class="btn btn-secondary">
                                        <span>Reset</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right Info Column -->
                <div class="col-lg-4 col-12">
                    <!-- Account Overview -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="mb-0">Ringkasan Hak Akses</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between p-3 rounded mb-2" style="background: #f8fafc; border-radius: 10px;">
                                <span class="text-muted small">Status Akun</span>
                                <span class="badge badge-success">Aktif</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between p-3 rounded mb-2" style="background: #f8fafc; border-radius: 10px;">
                                <span class="text-muted small">Tingkat Akses</span>
                                <span class="font-weight-bold text-dark">Administrator</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between p-3 rounded" style="background: #f8fafc; border-radius: 10px;">
                                <span class="text-muted small">Waktu Sesi</span>
                                <span class="font-weight-bold text-dark">{{ now()->format('H:i') }} WIB</span>
                            </div>
                        </div>
                    </div>

                    <!-- Security Tips Card -->
                    <div class="card">
                        <div class="card-body d-flex gap-3 align-items-start">
                            <div class="stat-icon-box stat-icon-amber mr-2" style="width: 36px; height: 36px; border-radius: 10px;">
                                <span class="material-symbols-outlined" style="font-size: 18px;">shield</span>
                            </div>
                            <div>
                                <h6 class="mb-1 font-weight-bold text-dark" style="font-size: 13px;">Tips Keamanan Akun</h6>
                                <p class="text-muted small mb-0" style="font-size: 11.5px; line-height: 1.5;">
                                    Pastikan kata sandi minimal 8 karakter dengan kombinasi huruf dan angka untuk keamanan data sistem.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection