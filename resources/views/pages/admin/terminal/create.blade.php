@extends('layouts.app', ['title' => 'Tambah Terminal'])

@section('content')
    <div class="main-content">
        <section class="section">
            <!-- PAGE HEADER: Modern Enterprise Header & Breadcrumb -->
            <div class="adm-page-header" style="margin-bottom: 20px;">
                <!-- Subtle Breadcrumb -->
                <div class="adm-breadcrumb" style="display: flex; align-items: center; gap: 6px; font-size: 11.5px; color: #64748b; margin-bottom: 12px;">
                    <a href="{{ route('admin.dashboard') }}" style="color: #64748b; text-decoration: none; font-weight: 500;">Home</a>
                    <span style="font-size: 8px; color: #94a3b8;"><i class="fas fa-chevron-right"></i></span>
                    <span style="color: #64748b;">Master Data</span>
                    <span style="font-size: 8px; color: #94a3b8;"><i class="fas fa-chevron-right"></i></span>
                    <a href="{{ route('admin.terminal.index') }}" style="color: #64748b; text-decoration: none; font-weight: 500;">Terminal</a>
                    <span style="font-size: 8px; color: #94a3b8;"><i class="fas fa-chevron-right"></i></span>
                    <span style="color: #0f172a; font-weight: 600;">Tambah</span>
                </div>

                <!-- Page Title Row -->
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 42px; height: 42px; border-radius: 10px; background: #2563eb; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.22);">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h1 style="font-size: 19px; font-weight: 700; color: #0f172a; margin: 0; line-height: 1.2; letter-spacing: -0.015em;">Tambah Terminal</h1>
                        <p style="font-size: 12.5px; color: #64748b; margin: 3px 0 0 0; line-height: 1.3;">Daftarkan lokasi terminal keberangkatan atau titik tujuan baru</p>
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
                                <span>Form Terminal</span>
                            </div>
                            <div class="adm-form-header-note">
                                <span>Kolom bertanda</span>
                                <span class="req-star">*</span>
                                <span>wajib diisi</span>
                            </div>
                        </div>

                        <!-- Form -->
                        <form method="POST" action="{{ route('admin.terminal.store') }}" style="margin: 0;">
                            @csrf
                            <div class="adm-form-body">
                                <!-- Kode Terminal & Kota (Two Columns) -->
                                <div class="row" style="margin-left: -9px; margin-right: -9px;">
                                    <div class="col-md-6 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Kode Terminal <span class="req-star">*</span>
                                            </label>
                                            <input type="text" name="kode_terminal"
                                                class="adm-input @error('kode_terminal') is-invalid @enderror"
                                                value="{{ old('kode_terminal') }}" required maxlength="30"
                                                placeholder="Contoh: TRM-MKS-01">
                                            @error('kode_terminal')
                                                <div class="invalid-feedback" style="font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Kota / Kabupaten <span class="req-star">*</span>
                                            </label>
                                            <input type="text" name="kota"
                                                class="adm-input @error('kota') is-invalid @enderror"
                                                value="{{ old('kota') }}" required maxlength="100"
                                                placeholder="Contoh: Makassar">
                                            @error('kota')
                                                <div class="invalid-feedback" style="font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Nama Terminal -->
                                <div class="adm-form-group">
                                    <label class="adm-form-label">
                                        Nama Terminal <span class="req-star">*</span>
                                    </label>
                                    <input type="text" name="nama_terminal"
                                        class="adm-input @error('nama_terminal') is-invalid @enderror"
                                        value="{{ old('nama_terminal') }}" required maxlength="150"
                                        placeholder="Contoh: Terminal Regional Daya">
                                    @error('nama_terminal')
                                        <div class="invalid-feedback" style="font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Provinsi & Status (Two Columns) -->
                                <div class="row" style="margin-left: -9px; margin-right: -9px;">
                                    <div class="col-md-6 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Provinsi
                                            </label>
                                            <input type="text" name="provinsi" class="adm-input"
                                                value="{{ old('provinsi') }}" maxlength="100"
                                                placeholder="Contoh: Sulawesi Selatan">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Status Operasional <span class="req-star">*</span>
                                            </label>
                                            <select name="status" class="adm-select">
                                                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Alamat -->
                                <div class="adm-form-group" style="margin-bottom: 22px;">
                                    <label class="adm-form-label">
                                        Alamat Lengkap
                                    </label>
                                    <textarea name="alamat" class="adm-textarea" rows="3"
                                        placeholder="Masukkan alamat detail lokasi terminal">{{ old('alamat') }}</textarea>
                                </div>
                            </div>

                            <!-- Form Action Area / Footer -->
                            <div class="adm-form-footer">
                                <button type="submit" class="adm-btn-submit">
                                    <i class="fas fa-save" style="font-size: 12px;"></i>
                                    <span>Simpan Terminal</span>
                                </button>
                                <a href="{{ route('admin.terminal.index') }}" class="adm-btn-cancel">
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
