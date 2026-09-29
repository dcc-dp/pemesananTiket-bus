@extends('layouts.app', ['title' => 'Tambah Bus'])

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
                    <a href="{{ route('admin.bus.index') }}" style="color: #64748b; text-decoration: none; font-weight: 500;">Bus</a>
                    <span style="font-size: 8px; color: #94a3b8;"><i class="fas fa-chevron-right"></i></span>
                    <span style="color: #0f172a; font-weight: 600;">Tambah</span>
                </div>

                <!-- Page Title Row -->
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 42px; height: 42px; border-radius: 10px; background: #2563eb; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.22);">
                        <i class="fas fa-bus"></i>
                    </div>
                    <div>
                        <h1 style="font-size: 19px; font-weight: 700; color: #0f172a; margin: 0; line-height: 1.2; letter-spacing: -0.015em;">Tambah Bus</h1>
                        <p style="font-size: 12.5px; color: #64748b; margin: 3px 0 0 0; line-height: 1.3;">Tambahkan armada bus baru beserta konfigurasi kapasitas kursi</p>
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
                                <span>Form Bus</span>
                            </div>
                            <div class="adm-form-header-note">
                                <span>Kolom bertanda</span>
                                <span class="req-star">*</span>
                                <span>wajib diisi</span>
                            </div>
                        </div>

                        <!-- Form -->
                        <form method="POST" action="{{ route('admin.bus.store') }}" style="margin: 0;">
                            @csrf
                            <div class="adm-form-body">
                                <!-- Operator & Nama Bus (Two Columns) -->
                                <div class="row" style="margin-left: -9px; margin-right: -9px;">
                                    <div class="col-md-6 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Operator Bus <span class="req-star">*</span>
                                            </label>
                                            <select name="operator_id" class="adm-select @error('operator_id') is-invalid @enderror" required>
                                                <option value="">-- Pilih Operator Bus --</option>
                                                @foreach ($operators as $operator)
                                                    <option value="{{ $operator->id }}" {{ old('operator_id') == $operator->id ? 'selected' : '' }}>
                                                        {{ $operator->nama_operator }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('operator_id')
                                                <div class="invalid-feedback" style="font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Nama Bus <span class="req-star">*</span>
                                            </label>
                                            <input type="text" name="nama_bus" 
                                                class="adm-input @error('nama_bus') is-invalid @enderror"
                                                value="{{ old('nama_bus') }}" required maxlength="100"
                                                placeholder="Contoh: Damri Royal Class">
                                            @error('nama_bus')
                                                <div class="invalid-feedback" style="font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Kode Bus & Nomor Polisi (Two Columns) -->
                                <div class="row" style="margin-left: -9px; margin-right: -9px;">
                                    <div class="col-md-6 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Kode Bus <span class="req-star">*</span>
                                            </label>
                                            <input type="text" name="kode_bus" 
                                                class="adm-input @error('kode_bus') is-invalid @enderror"
                                                value="{{ old('kode_bus') }}" required maxlength="30"
                                                placeholder="Contoh: BUS-DAMRI-01">
                                            @error('kode_bus')
                                                <div class="invalid-feedback" style="font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Plat Nomor Polisi <span class="req-star">*</span>
                                            </label>
                                            <input type="text" name="nomor_polisi" 
                                                class="adm-input @error('nomor_polisi') is-invalid @enderror"
                                                value="{{ old('nomor_polisi') }}" required maxlength="20"
                                                placeholder="Contoh: B 7123 TAA">
                                            @error('nomor_polisi')
                                                <div class="invalid-feedback" style="font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Kelas, Kapasitas Kursi & Status (Three Columns) -->
                                <div class="row" style="margin-left: -9px; margin-right: -9px;">
                                    <div class="col-md-4 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Kelas Bus <span class="req-star">*</span>
                                            </label>
                                            <select name="kelas" class="adm-select @error('kelas') is-invalid @enderror" required>
                                                <option value="ekonomi" {{ old('kelas') == 'ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                                                <option value="bisnis" {{ old('kelas') == 'bisnis' ? 'selected' : '' }}>Bisnis</option>
                                                <option value="executive" {{ old('kelas', 'executive') == 'executive' ? 'selected' : '' }}>Executive</option>
                                                <option value="sleeper" {{ old('kelas') == 'sleeper' ? 'selected' : '' }}>Sleeper</option>
                                            </select>
                                            @error('kelas')
                                                <div class="invalid-feedback" style="font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Kapasitas Kursi <span class="req-star">*</span>
                                            </label>
                                            <input type="number" name="kapasitas" 
                                                class="adm-input @error('kapasitas') is-invalid @enderror"
                                                value="{{ old('kapasitas', 44) }}" min="1" max="60" required
                                                placeholder="Contoh: 44">
                                            @error('kapasitas')
                                                <div class="invalid-feedback" style="font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Status Bus <span class="req-star">*</span>
                                            </label>
                                            <select name="status" class="adm-select">
                                                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                <option value="perbaikan" {{ old('status') == 'perbaikan' ? 'selected' : '' }}>Dalam Perbaikan</option>
                                                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Fasilitas -->
                                <div class="adm-form-group" style="margin-bottom: 22px;">
                                    <label class="adm-form-label">
                                        Fasilitas
                                    </label>
                                    <textarea name="fasilitas" class="adm-textarea" rows="3"
                                        placeholder="Contoh: AC, Toilet, WiFi, Reclining Seat, USB Charger, Selimut">{{ old('fasilitas') }}</textarea>
                                </div>
                            </div>

                            <!-- Form Action Area / Footer -->
                            <div class="adm-form-footer">
                                <button type="submit" class="adm-btn-submit">
                                    <i class="fas fa-save" style="font-size: 12px;"></i>
                                    <span>Simpan Bus</span>
                                </button>
                                <a href="{{ route('admin.bus.index') }}" class="adm-btn-cancel">
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