@extends('layouts.app', ['title' => 'Profil Saya'])

@section('content')
    <div class="main-content">
        <section class="section">
            {{-- Header Section --}}
            <div class="section-header" style="background: linear-gradient(135deg, #0B1F3A 0%, #123E73 100%); border-radius: 16px; padding: 30px 35px; margin-bottom: 30px; box-shadow: 0 8px 32px rgba(11,31,58,0.15);">
                <div class="d-flex align-items-center justify-content-between w-100 flex-wrap">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 48px; height: 48px; background: rgba(255,255,255,0.12); border-radius: 14px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.08);">
                            <i class="fas fa-id-card" style="color: #ffffff; font-size: 1.3rem;"></i>
                        </div>
                        <div>
                            <h1 style="color: #ffffff; font-weight: 700; font-size: 1.8rem; margin-bottom: 2px;">Profil Saya</h1>
                            <p style="color: rgba(255,255,255,0.7); margin: 0; font-size: 0.95rem;">
                                <i class="far fa-user me-1"></i> Kelola informasi akun Anda
                            </p>
                        </div>
                    </div>
                    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                        <span style="background: rgba(255,255,255,0.12); padding: 6px 16px; border-radius: 50px; color: #fff; font-size: 0.85rem; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.08);">
                            <i class="fas fa-user-shield me-1"></i> {{ ucfirst($user->role) }}
                        </span>
                        <span style="background: rgba(255,255,255,0.12); padding: 6px 16px; border-radius: 50px; color: #fff; font-size: 0.85rem; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.08);">
                            <i class="far fa-clock me-1"></i> Terakhir login: {{ now()->format('d M Y H:i') }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                {{-- Profile Card --}}
                <div class="col-12 col-md-8 col-lg-8 col-xl-7">
                    <div class="card border-0 rounded-4 shadow-sm" style="overflow: hidden;">
                        {{-- Profile Header with Cover --}}
                        <div style="background: linear-gradient(135deg, #0B1F3A 0%, #123E73 50%, #1E5AA8 100%); padding: 40px 30px 30px; position: relative;">
                            <div style="position: absolute; top: -50%; right: -20%; width: 300px; height: 300px; background: rgba(255,255,255,0.03); border-radius: 50%; pointer-events: none;"></div>
                            <div style="position: absolute; bottom: -30%; left: -10%; width: 200px; height: 200px; background: rgba(255,255,255,0.02); border-radius: 50%; pointer-events: none;"></div>
                            
                            <div class="d-flex align-items-center gap-4 position-relative" style="z-index: 2;">
                                <div style="position: relative;">
                                    <img alt="Avatar" src="{{ asset('img/avatar/avatar-1.png') }}" 
                                         style="width: 90px; height: 90px; border-radius: 50%; border: 4px solid rgba(255,255,255,0.3); box-shadow: 0 8px 24px rgba(0,0,0,0.15); background: #ffffff; padding: 2px; object-fit: cover;">
                                    <div style="position: absolute; bottom: 0; right: 0; width: 28px; height: 28px; background: #2dce89; border-radius: 50%; border: 3px solid #ffffff; box-shadow: 0 2px 8px rgba(45,206,137,0.3);"></div>
                                </div>
                                <div>
                                    <h3 style="color: #ffffff; font-weight: 700; margin: 0; font-size: 1.6rem;">{{ $user->name }}</h3>
                                    <div style="display: flex; gap: 8px; align-items: center; margin-top: 4px; flex-wrap: wrap;">
                                        <span class="badge rounded-pill px-3 py-2" style="background: rgba(255,255,255,0.15); color: #ffffff; backdrop-filter: blur(10px); font-weight: 500; border: 1px solid rgba(255,255,255,0.08);">
                                            <i class="fas fa-user-tag me-1"></i> {{ ucfirst($user->role) }}
                                        </span>
                                        <span style="color: rgba(255,255,255,0.7); font-size: 0.9rem;">
                                            <i class="far fa-envelope me-1"></i> {{ $user->email ?? 'Belum diisi' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Form --}}
                        <div class="card-body p-4 p-md-5">
                            <form method="POST" action="{{ route('admin.profile.update') }}">
                                @csrf
                                
                                {{-- Informasi Dasar --}}
                                <div style="margin-bottom: 24px;">
                                    <h5 style="color: #0B1F3A; font-weight: 700; font-size: 1rem; margin-bottom: 16px; display: flex; align-items: center; gap: 10px;">
                                        <span style="width: 4px; height: 20px; background: linear-gradient(135deg, #123E73, #1E5AA8); border-radius: 4px; display: inline-block;"></span>
                                        Informasi Dasar
                                    </h5>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label style="font-size: 0.85rem; font-weight: 600; color: #0B1F3A; margin-bottom: 6px;">
                                                    Nama Lengkap <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="name" 
                                                       class="form-control @error('name') is-invalid @enderror" 
                                                       style="border-radius: 10px; border: 2px solid #e2e8f0; padding: 10px 16px; font-size: 0.95rem; transition: all 0.3s ease;"
                                                       onfocus="this.style.borderColor='#1E5AA8'; this.style.boxShadow='0 0 0 4px rgba(30,90,168,0.1)'"
                                                       onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'"
                                                       value="{{ old('name', $user->name) }}" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label style="font-size: 0.85rem; font-weight: 600; color: #0B1F3A; margin-bottom: 6px;">
                                                    Username <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="username" 
                                                       class="form-control @error('username') is-invalid @enderror" 
                                                       style="border-radius: 10px; border: 2px solid #e2e8f0; padding: 10px 16px; font-size: 0.95rem; transition: all 0.3s ease;"
                                                       onfocus="this.style.borderColor='#1E5AA8'; this.style.boxShadow='0 0 0 4px rgba(30,90,168,0.1)'"
                                                       onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'"
                                                       value="{{ old('username', $user->username) }}" required>
                                                @error('username')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label style="font-size: 0.85rem; font-weight: 600; color: #0B1F3A; margin-bottom: 6px;">
                                                    Email
                                                </label>
                                                <input type="email" name="email" 
                                                       class="form-control @error('email') is-invalid @enderror" 
                                                       style="border-radius: 10px; border: 2px solid #e2e8f0; padding: 10px 16px; font-size: 0.95rem; transition: all 0.3s ease;"
                                                       onfocus="this.style.borderColor='#1E5AA8'; this.style.boxShadow='0 0 0 4px rgba(30,90,168,0.1)'"
                                                       onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'"
                                                       value="{{ old('email', $user->email) }}">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label style="font-size: 0.85rem; font-weight: 600; color: #0B1F3A; margin-bottom: 6px;">
                                                    <i class="fas fa-phone me-1"></i> No. HP
                                                </label>
                                                <input type="text" name="phone" 
                                                       class="form-control" 
                                                       style="border-radius: 10px; border: 2px solid #e2e8f0; padding: 10px 16px; font-size: 0.95rem; transition: all 0.3s ease;"
                                                       onfocus="this.style.borderColor='#1E5AA8'; this.style.boxShadow='0 0 0 4px rgba(30,90,168,0.1)'"
                                                       onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'"
                                                       value="{{ old('phone', $user->phone) }}" maxlength="30" placeholder="Masukkan nomor telepon">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr style="border-color: #e2e8f0; margin: 24px 0;">

                                {{-- Ganti Password --}}
                                <div style="margin-bottom: 24px;">
                                    <h5 style="color: #0B1F3A; font-weight: 700; font-size: 1rem; margin-bottom: 16px; display: flex; align-items: center; gap: 10px;">
                                        <span style="width: 4px; height: 20px; background: linear-gradient(135deg, #123E73, #1E5AA8); border-radius: 4px; display: inline-block;"></span>
                                        Ganti Password 
                                        <small style="color: #6C757D; font-weight: 400; font-size: 0.85rem;">(opsional)</small>
                                    </h5>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label style="font-size: 0.85rem; font-weight: 600; color: #0B1F3A; margin-bottom: 6px;">
                                                    <i class="fas fa-lock me-1"></i> Password Baru
                                                </label>
                                                <input type="password" name="password" 
                                                       class="form-control @error('password') is-invalid @enderror" 
                                                       style="border-radius: 10px; border: 2px solid #e2e8f0; padding: 10px 16px; font-size: 0.95rem; transition: all 0.3s ease;"
                                                       onfocus="this.style.borderColor='#1E5AA8'; this.style.boxShadow='0 0 0 4px rgba(30,90,168,0.1)'"
                                                       onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'"
                                                       minlength="6" placeholder="Kosongkan jika tidak diganti">
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label style="font-size: 0.85rem; font-weight: 600; color: #0B1F3A; margin-bottom: 6px;">
                                                    <i class="fas fa-check-circle me-1"></i> Konfirmasi Password
                                                </label>
                                                <input type="password" name="password_confirmation" 
                                                       class="form-control" 
                                                       style="border-radius: 10px; border: 2px solid #e2e8f0; padding: 10px 16px; font-size: 0.95rem; transition: all 0.3s ease;"
                                                       onfocus="this.style.borderColor='#1E5AA8'; this.style.boxShadow='0 0 0 4px rgba(30,90,168,0.1)'"
                                                       onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'"
                                                       minlength="6" placeholder="Ulangi password baru">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Button Actions --}}
                                <div style="display: flex; gap: 12px; flex-wrap: wrap; padding-top: 8px; border-top: 2px solid #f0f2f5;">
                                    <button type="submit" class="btn btn-primary rounded-3 fw-semibold px-4 py-2" 
                                            style="background: linear-gradient(135deg, #123E73, #1E5AA8); border: none; transition: all 0.3s ease; box-shadow: 0 4px 16px rgba(30,90,168,0.25);"
                                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 24px rgba(30,90,168,0.35)'"
                                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 16px rgba(30,90,168,0.25)'">
                                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                                    </button>
                                    <button type="reset" class="btn btn-light rounded-3 fw-semibold px-4 py-2" 
                                            style="border: 2px solid #e2e8f0; color: #6C757D; background: #ffffff; transition: all 0.3s ease;"
                                            onmouseover="this.style.borderColor='#1E5AA8'; this.style.color='#1E5AA8'"
                                            onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='#6C757D'">
                                        <i class="fas fa-undo me-2"></i> Reset
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Sidebar Information --}}
                <div class="col-12 col-md-4 col-lg-4 col-xl-5">
                    <div class="row g-4">
                        {{-- Profile Summary Card --}}
                        <div class="col-12">
                            <div class="card border-0 rounded-4 shadow-sm" style="overflow: hidden;">
                                <div class="card-body p-4">
                                    <h6 style="color: #0B1F3A; font-weight: 700; font-size: 0.9rem; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                                        <i class="fas fa-chart-simple" style="color: #1E5AA8;"></i> Ringkasan Akun
                                    </h6>
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                                        <div style="background: #f8fafc; border-radius: 12px; padding: 14px; text-align: center;">
                                            <div style="font-size: 1.5rem; font-weight: 700; color: #1E5AA8;">1</div>
                                            <div style="font-size: 0.75rem; color: #6C757D;">Total Transaksi</div>
                                        </div>
                                        <div style="background: #f8fafc; border-radius: 12px; padding: 14px; text-align: center;">
                                            <div style="font-size: 1.5rem; font-weight: 700; color: #2dce89;">2</div>
                                            <div style="font-size: 0.75rem; color: #6C757D;">Booking Aktif</div>
                                        </div>
                                        <div style="background: #f8fafc; border-radius: 12px; padding: 14px; text-align: center;">
                                            <div style="font-size: 1.5rem; font-weight: 700; color: #f6c23e;">3</div>
                                            <div style="font-size: 0.75rem; color: #6C757D;">Riwayat</div>
                                        </div>
                                        <div style="background: #f8fafc; border-radius: 12px; padding: 14px; text-align: center;">
                                            <div style="font-size: 1.5rem; font-weight: 700; color: #6777ef;">4</div>
                                            <div style="font-size: 0.75rem; color: #6C757D;">Poin</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Quick Actions Card --}}
                        <div class="col-12">
                            <div class="card border-0 rounded-4 shadow-sm" style="overflow: hidden;">
                                <div class="card-body p-4">
                                    <h6 style="color: #0B1F3A; font-weight: 700; font-size: 0.9rem; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                                        <i class="fas fa-bolt" style="color: #1E5AA8;"></i> Akses Cepat
                                    </h6>
                                    <div style="display: flex; flex-direction: column; gap: 8px;">
                                        <a href="#" class="d-flex align-items-center gap-3 p-3 rounded-3" 
                                           style="background: #f8fafc; text-decoration: none; color: #0B1F3A; transition: all 0.3s ease;"
                                           onmouseover="this.style.background='#e8f0fe'"
                                           onmouseout="this.style.background='#f8fafc'">
                                            <i class="fas fa-ticket" style="color: #1E5AA8; font-size: 1rem;"></i>
                                            <span style="font-weight: 500;">Riwayat Pemesanan</span>
                                            <i class="fas fa-chevron-right ms-auto" style="color: #6C757D; font-size: 0.8rem;"></i>
                                        </a>
                                        <a href="#" class="d-flex align-items-center gap-3 p-3 rounded-3" 
                                           style="background: #f8fafc; text-decoration: none; color: #0B1F3A; transition: all 0.3s ease;"
                                           onmouseover="this.style.background='#e8f0fe'"
                                           onmouseout="this.style.background='#f8fafc'">
                                            <i class="fas fa-bus" style="color: #1E5AA8; font-size: 1rem;"></i>
                                            <span style="font-weight: 500;">Cari Jadwal</span>
                                            <i class="fas fa-chevron-right ms-auto" style="color: #6C757D; font-size: 0.8rem;"></i>
                                        </a>
                                        <a href="#" class="d-flex align-items-center gap-3 p-3 rounded-3" 
                                           style="background: #f8fafc; text-decoration: none; color: #0B1F3A; transition: all 0.3s ease;"
                                           onmouseover="this.style.background='#e8f0fe'"
                                           onmouseout="this.style.background='#f8fafc'">
                                            <i class="fas fa-credit-card" style="color: #1E5AA8; font-size: 1rem;"></i>
                                            <span style="font-weight: 500;">Metode Pembayaran</span>
                                            <i class="fas fa-chevron-right ms-auto" style="color: #6C757D; font-size: 0.8rem;"></i>
                                        </a>
                                        <a href="#" class="d-flex align-items-center gap-3 p-3 rounded-3" 
                                           style="background: #f8fafc; text-decoration: none; color: #0B1F3A; transition: all 0.3s ease;"
                                           onmouseover="this.style.background='#e8f0fe'"
                                           onmouseout="this.style.background='#f8fafc'">
                                            <i class="fas fa-headset" style="color: #1E5AA8; font-size: 1rem;"></i>
                                            <span style="font-weight: 500;">Bantuan & Dukungan</span>
                                            <i class="fas fa-chevron-right ms-auto" style="color: #6C757D; font-size: 0.8rem;"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Security Tips --}}
                        <div class="col-12">
                            <div class="card border-0 rounded-4 shadow-sm" style="overflow: hidden; background: linear-gradient(135deg, #fef3e2 0%, #fde8cc 100%); border: 1px solid #fbe0b5;">
                                <div class="card-body p-4">
                                    <div class="d-flex gap-3">
                                        <div style="width: 40px; height: 40px; background: #ffffff; border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.05); flex-shrink: 0;">
                                            <i class="fas fa-shield-alt" style="color: #f6c23e; font-size: 1.1rem;"></i>
                                        </div>
                                        <div>
                                            <h6 style="color: #0B1F3A; font-weight: 700; margin: 0 0 4px 0; font-size: 0.9rem;">Tips Keamanan</h6>
                                            <p style="color: #6C757D; font-size: 0.85rem; margin: 0; line-height: 1.5;">
                                                Gunakan password yang kuat dan jangan bagikan informasi akun Anda kepada siapapun.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection