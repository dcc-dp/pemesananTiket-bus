@extends('layouts.app', ['title' => 'Tambah Akun'])

@section('content')
    <div class="main-content">
        <section class="section">
            <!-- PAGE HEADER: Modern Enterprise Header & Breadcrumb -->
            <div class="adm-page-header" style="margin-bottom: 20px;">
                <!-- Subtle Breadcrumb -->
                <div class="adm-breadcrumb" style="display: flex; align-items: center; gap: 6px; font-size: 11.5px; color: #64748b; margin-bottom: 12px;">
                    <a href="{{ route('admin.dashboard') }}" style="color: #64748b; text-decoration: none; font-weight: 500;">Home</a>
                    <span style="font-size: 8px; color: #94a3b8;"><i class="fas fa-chevron-right"></i></span>
                    <span style="color: #64748b;">Pengaturan</span>
                    <span style="font-size: 8px; color: #94a3b8;"><i class="fas fa-chevron-right"></i></span>
                    <a href="{{ route('admin.akun.index') }}" style="color: #64748b; text-decoration: none; font-weight: 500;">Akun</a>
                    <span style="font-size: 8px; color: #94a3b8;"><i class="fas fa-chevron-right"></i></span>
                    <span style="color: #0f172a; font-weight: 600;">Tambah</span>
                </div>

                <!-- Page Title Row -->
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 42px; height: 42px; border-radius: 10px; background: #2563eb; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.22);">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div>
                        <h1 style="font-size: 19px; font-weight: 700; color: #0f172a; margin: 0; line-height: 1.2; letter-spacing: -0.015em;">Tambah Akun Pengguna</h1>
                        <p style="font-size: 12.5px; color: #64748b; margin: 3px 0 0 0; line-height: 1.3;">Daftarkan akun administrator baru atau akun pelanggan manual</p>
                    </div>
                </div>
            </div>

            <!-- FORM CARD CONTAINER: Full-width Enterprise SaaS Form -->
            <div class="row">
                <div class="col-12">
                    <div class="adm-form-card">
                        <!-- Card Header -->
                        <div class="adm-form-header">
                            <div class="adm-form-header-title">
                                <div style="width: 26px; height: 26px; border-radius: 6px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                                    <i class="fas fa-clipboard-list"></i>
                                </div>
                                <span>Form Akun Pengguna</span>
                            </div>
                            <div class="adm-form-header-note">
                                <span>Kolom bertanda</span>
                                <span class="req-star">*</span>
                                <span>wajib diisi</span>
                            </div>
                        </div>

                        <!-- Form -->
                        <form method="POST" action="{{ route('admin.akun.store') }}" style="margin: 0;">
                            @csrf
                            <div class="adm-form-body">
                                <!-- Nama Lengkap -->
                                <div class="adm-form-group">
                                    <label class="adm-form-label">
                                        Nama Lengkap <span class="req-star">*</span>
                                    </label>
                                    <input type="text" name="name" class="adm-input @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}" required maxlength="255" placeholder="Contoh: Ahmad Fauzan">
                                    @error('name')
                                        <div class="invalid-feedback" style="font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Username & Email (Two Columns) -->
                                <div class="row" style="margin-left: -9px; margin-right: -9px;">
                                    <div class="col-md-6 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Username <span class="req-star">*</span>
                                            </label>
                                            <input type="text" name="username" class="adm-input @error('username') is-invalid @enderror"
                                                value="{{ old('username') }}" required maxlength="255" placeholder="Contoh: ahmad_admin">
                                            @error('username')
                                                <div class="invalid-feedback" style="font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Alamat Email
                                            </label>
                                            <input type="email" name="email" class="adm-input @error('email') is-invalid @enderror"
                                                value="{{ old('email') }}" placeholder="Contoh: ahmad@example.com">
                                            @error('email')
                                                <div class="invalid-feedback" style="font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- No HP & Role (Two Columns) -->
                                <div class="row" style="margin-left: -9px; margin-right: -9px;">
                                    <div class="col-md-6 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                No. Handphone / WhatsApp
                                            </label>
                                            <input type="text" name="phone" class="adm-input" value="{{ old('phone') }}" maxlength="30"
                                                placeholder="Contoh: 081234567890">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Hak Akses / Peran <span class="req-star">*</span>
                                            </label>
                                            <select name="role" class="adm-select">
                                                <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer (Pelanggan)</option>
                                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator (Akses Penuh)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Password & Konfirmasi Password (Two Columns) -->
                                <div class="row" style="margin-left: -9px; margin-right: -9px;">
                                    <div class="col-md-6 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group" style="margin-bottom: 22px;">
                                            <label class="adm-form-label">
                                                Kata Sandi / Password <span class="req-star">*</span>
                                            </label>
                                            <input type="password" name="password" class="adm-input @error('password') is-invalid @enderror"
                                                required minlength="6" placeholder="Minimal 6 karakter">
                                            @error('password')
                                                <div class="invalid-feedback" style="font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group" style="margin-bottom: 22px;">
                                            <label class="adm-form-label">
                                                Konfirmasi Kata Sandi <span class="req-star">*</span>
                                            </label>
                                            <input type="password" name="password_confirmation" class="adm-input"
                                                required minlength="6" placeholder="Ketik ulang kata sandi">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Action Area / Footer -->
                            <div class="adm-form-footer">
                                <button type="submit" class="adm-btn-submit">
                                    <i class="fas fa-save" style="font-size: 12px;"></i>
                                    <span>Simpan Akun</span>
                                </button>
                                <a href="{{ route('admin.akun.index') }}" class="adm-btn-cancel">
                                    <span>Batal</span>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection