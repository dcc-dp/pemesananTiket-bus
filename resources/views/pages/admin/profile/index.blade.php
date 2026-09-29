@extends('layouts.app', ['title' => 'Profil Saya'])

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
                    <span style="color: #0f172a; font-weight: 600;">Profil Saya</span>
                </div>

                <!-- Page Title Row -->
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <div style="width: 42px; height: 42px; border-radius: 10px; background: #2563eb; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.22);">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div>
                            <h1 style="font-size: 19px; font-weight: 700; color: #0f172a; margin: 0; line-height: 1.2; letter-spacing: -0.015em;">Profil Saya</h1>
                            <p style="font-size: 12.5px; color: #64748b; margin: 3px 0 0 0; line-height: 1.3;">Kelola identitas akun administrator dan preferensi keamanan</p>
                        </div>
                    </div>
                    <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                        <span style="background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; font-size: 11.5px; font-weight: 600; padding: 5px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 5px;">
                            <i class="fas fa-shield-alt" style="font-size: 11px;"></i> {{ ucfirst($user->role) }}
                        </span>
                        <span style="background: #ffffff; color: #64748b; border: 1px solid #e2e8f0; font-size: 11.5px; font-weight: 500; padding: 5px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 5px;">
                            <i class="far fa-clock" style="color: #2563eb; font-size: 11px;"></i> Sesi Aktif
                        </span>
                    </div>
                </div>
            </div>

            <!-- TWO-COLUMN ENTERPRISE LAYOUT -->
            <div class="row">
                <!-- LEFT COLUMN: Profile Identity Card & Security Summary -->
                <div class="col-lg-4 col-md-5 col-12 mb-4 mb-md-0">
                    <!-- Profile Card -->
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04); overflow: hidden; margin-bottom: 16px;">
                        <!-- Top Accent Banner -->
                        <div style="height: 72px; background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-bottom: 1px solid #e2e8f0;"></div>
                        
                        <div style="padding: 0 20px 20px 20px; text-align: center; margin-top: -38px;">
                            <!-- Avatar with Online Status -->
                            <div style="position: relative; display: inline-block; margin-bottom: 12px;">
                                <img alt="Avatar" src="{{ asset('img/avatar/avatar-1.png') }}" 
                                     style="width: 76px; height: 76px; border-radius: 50%; border: 3px solid #ffffff; box-shadow: 0 2px 8px rgba(0,0,0,0.1); background: #ffffff; object-fit: cover;">
                                <span style="position: absolute; bottom: 2px; right: 2px; width: 14px; height: 14px; background: #10b981; border: 2px solid #ffffff; border-radius: 50%;" title="Online"></span>
                            </div>

                            <!-- Name & Meta -->
                            <h2 style="font-size: 15px; font-weight: 700; color: #0f172a; margin: 0 0 2px 0;">{{ $user->name }}</h2>
                            <p style="font-size: 11.5px; color: #64748b; margin: 0 0 10px 0; font-family: monospace;">@<span>{{ $user->username }}</span></p>
                            
                            <span style="display: inline-block; background: #f1f5f9; color: #475569; font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 6px; border: 1px solid #e2e8f0;">
                                <i class="fas fa-user-shield" style="font-size: 10px; color: #2563eb; margin-right: 4px;"></i> {{ ucfirst($user->role) }}
                            </span>

                            <!-- Divider -->
                            <hr style="border: 0; border-top: 1px solid #f1f5f9; margin: 18px 0 16px 0;">

                            <!-- Account Details List -->
                            <div style="text-align: left; display: flex; flex-direction: column; gap: 12px;">
                                <div style="display: flex; align-items: center; justify-content: space-between; font-size: 12px;">
                                    <span style="color: #64748b; display: flex; align-items: center; gap: 8px;">
                                        <i class="far fa-envelope" style="width: 14px; color: #94a3b8; font-size: 12px;"></i> Email
                                    </span>
                                    <span style="font-weight: 600; color: #0f172a; max-width: 170px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        {{ $user->email ?? '-' }}
                                    </span>
                                </div>

                                <div style="display: flex; align-items: center; justify-content: space-between; font-size: 12px;">
                                    <span style="color: #64748b; display: flex; align-items: center; gap: 8px;">
                                        <i class="fas fa-phone-alt" style="width: 14px; color: #94a3b8; font-size: 11px;"></i> No. HP
                                    </span>
                                    <span style="font-weight: 600; color: #0f172a;">
                                        {{ $user->phone ?? '-' }}
                                    </span>
                                </div>

                                <div style="display: flex; align-items: center; justify-content: space-between; font-size: 12px;">
                                    <span style="color: #64748b; display: flex; align-items: center; gap: 8px;">
                                        <i class="far fa-calendar-alt" style="width: 14px; color: #94a3b8; font-size: 12px;"></i> Terdaftar
                                    </span>
                                    <span style="font-weight: 600; color: #0f172a;">
                                        {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                                    </span>
                                </div>

                                <div style="display: flex; align-items: center; justify-content: space-between; font-size: 12px;">
                                    <span style="color: #64748b; display: flex; align-items: center; gap: 8px;">
                                        <i class="fas fa-shield-alt" style="width: 14px; color: #94a3b8; font-size: 12px;"></i> Status
                                    </span>
                                    <span style="color: #16a34a; font-weight: 600; font-size: 11px; background: #dcfce7; padding: 1px 7px; border-radius: 4px;">
                                        Aktif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security Info Box -->
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px 16px;">
                        <div style="display: flex; gap: 10px; align-items: flex-start;">
                            <div style="width: 28px; height: 28px; border-radius: 6px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 12px; flex-shrink: 0; margin-top: 1px;">
                                <i class="fas fa-lock"></i>
                            </div>
                            <div>
                                <h3 style="font-size: 12px; font-weight: 700; color: #0f172a; margin: 0 0 3px 0;">Keamanan Akun</h3>
                                <p style="font-size: 11px; color: #64748b; margin: 0; line-height: 1.45;">
                                    Gunakan password minimal 6 karakter. Pastikan tidak membagikan akses login admin Anda kepada pihak lain.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN: Form Card -->
                <div class="col-lg-8 col-md-7 col-12">
                    <div class="adm-form-card">
                        <!-- Card Header -->
                        <div class="adm-form-header">
                            <div class="adm-form-header-title">
                                <div style="width: 26px; height: 26px; border-radius: 6px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                                    <i class="fas fa-user-edit"></i>
                                </div>
                                <span>Perbarui Informasi Profil</span>
                            </div>
                            <div class="adm-form-header-note">
                                <span>Kolom bertanda</span>
                                <span class="req-star">*</span>
                                <span>wajib diisi</span>
                            </div>
                        </div>

                        <!-- Form -->
                        <form method="POST" action="{{ route('admin.profile.update') }}" style="margin: 0;">
                            @csrf
                            
                            <div class="adm-form-body">
                                <!-- SECTION 1: Informasi Profil -->
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
                                    <span style="width: 3px; height: 14px; background: #2563eb; border-radius: 2px; display: inline-block;"></span>
                                    <h3 style="font-size: 12.5px; font-weight: 700; color: #0f172a; margin: 0; text-transform: uppercase; letter-spacing: 0.3px;">Informasi Akun</h3>
                                </div>

                                <!-- Nama Lengkap -->
                                <div class="adm-form-group">
                                    <label class="adm-form-label">
                                        Nama Lengkap <span class="req-star">*</span>
                                    </label>
                                    <input type="text" name="name" 
                                           class="adm-input @error('name') is-invalid @enderror" 
                                           value="{{ old('name', $user->name) }}" 
                                           required 
                                           placeholder="Masukkan nama lengkap">
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
                                            <input type="text" name="username" 
                                                   class="adm-input @error('username') is-invalid @enderror" 
                                                   value="{{ old('username', $user->username) }}" 
                                                   required 
                                                   placeholder="Masukkan username">
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
                                            <input type="email" name="email" 
                                                   class="adm-input @error('email') is-invalid @enderror" 
                                                   value="{{ old('email', $user->email) }}" 
                                                   placeholder="admin@example.com">
                                            @error('email')
                                                <div class="invalid-feedback" style="font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- No. Telepon / HP -->
                                <div class="adm-form-group">
                                    <label class="adm-form-label">
                                        No. Handphone / WhatsApp
                                    </label>
                                    <input type="text" name="phone" 
                                           class="adm-input" 
                                           value="{{ old('phone', $user->phone) }}" 
                                           maxlength="30" 
                                           placeholder="Contoh: 081234567890">
                                </div>

                                <!-- Subtle Section Separator -->
                                <hr style="border: 0; border-top: 1px dashed #e2e8f0; margin: 24px 0 20px 0;">

                                <!-- SECTION 2: Ganti Password -->
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <span style="width: 3px; height: 14px; background: #64748b; border-radius: 2px; display: inline-block;"></span>
                                        <h3 style="font-size: 12.5px; font-weight: 700; color: #0f172a; margin: 0; text-transform: uppercase; letter-spacing: 0.3px;">Ubah Password</h3>
                                    </div>
                                    <span style="font-size: 11px; color: #94a3b8; font-weight: 500;">Opsional</span>
                                </div>
                                <p style="font-size: 11.5px; color: #64748b; margin: 0 0 16px 0;">
                                    Kosongkan bidang di bawah jika Anda tidak ingin mengubah password saat ini.
                                </p>

                                <!-- Password Baru & Konfirmasi (Two Columns) -->
                                <div class="row" style="margin-left: -9px; margin-right: -9px;">
                                    <div class="col-md-6 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Password Baru
                                            </label>
                                            <input type="password" name="password" 
                                                   class="adm-input @error('password') is-invalid @enderror" 
                                                   minlength="6" 
                                                   placeholder="Minimal 6 karakter">
                                            @error('password')
                                                <div class="invalid-feedback" style="font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Konfirmasi Password Baru
                                            </label>
                                            <input type="password" name="password_confirmation" 
                                                   class="adm-input" 
                                                   minlength="6" 
                                                   placeholder="Ulangi password baru">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Action Area / Footer -->
                            <div class="adm-form-footer">
                                <button type="submit" class="adm-btn-submit">
                                    <i class="fas fa-save" style="font-size: 12px;"></i>
                                    <span>Simpan Perubahan</span>
                                </button>
                                <button type="reset" class="adm-btn-cancel" style="cursor: pointer;">
                                    <i class="fas fa-undo" style="font-size: 11.5px;"></i>
                                    <span>Reset</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection