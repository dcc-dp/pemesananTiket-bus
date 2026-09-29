@extends('layouts.app', ['title' => 'Edit Operator'])

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
                    <a href="{{ route('admin.operator.index') }}" style="color: #64748b; text-decoration: none; font-weight: 500;">Operator</a>
                    <span style="font-size: 8px; color: #94a3b8;"><i class="fas fa-chevron-right"></i></span>
                    <span style="color: #0f172a; font-weight: 600;">Edit</span>
                </div>

                <!-- Page Title Row -->
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 42px; height: 42px; border-radius: 10px; background: #2563eb; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.22);">
                        <i class="fas fa-building"></i>
                    </div>
                    <div>
                        <h1 style="font-size: 19px; font-weight: 700; color: #0f172a; margin: 0; line-height: 1.2; letter-spacing: -0.015em;">Edit Operator</h1>
                        <p style="font-size: 12.5px; color: #64748b; margin: 3px 0 0 0; line-height: 1.3;">Perbarui informasi perusahaan otobus (PO)</p>
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
                                <span>Form Operator</span>
                            </div>
                            <div class="adm-form-header-note">
                                <span>Kolom bertanda</span>
                                <span class="req-star">*</span>
                                <span>wajib diisi</span>
                            </div>
                        </div>

                        <!-- Form -->
                        <form method="POST" action="{{ route('admin.operator.update', $data->id) }}" style="margin: 0;">
                            @csrf
                            @method('PUT')
                            <div class="adm-form-body">
                                <!-- Kode Operator -->
                                <div class="adm-form-group">
                                    <label class="adm-form-label">
                                        Kode Operator <span class="req-star">*</span>
                                    </label>
                                    <input type="text" name="kode_operator" 
                                        class="adm-input @error('kode_operator') is-invalid @enderror"
                                        value="{{ old('kode_operator', $data->kode_operator) }}" required maxlength="30">
                                    @error('kode_operator')
                                        <div class="invalid-feedback" style="font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Nama Operator -->
                                <div class="adm-form-group">
                                    <label class="adm-form-label">
                                        Nama Operator <span class="req-star">*</span>
                                    </label>
                                    <input type="text" name="nama_operator" 
                                        class="adm-input @error('nama_operator') is-invalid @enderror"
                                        value="{{ old('nama_operator', $data->nama_operator) }}" required maxlength="150">
                                    @error('nama_operator')
                                        <div class="invalid-feedback" style="font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Alamat -->
                                <div class="adm-form-group">
                                    <label class="adm-form-label">
                                        Alamat
                                    </label>
                                    <textarea name="alamat" class="adm-textarea" rows="3">{{ old('alamat', $data->alamat) }}</textarea>
                                </div>

                                <!-- Telepon & Email (Two Columns Symmetrical Grid) -->
                                <div class="row" style="margin-left: -9px; margin-right: -9px;">
                                    <div class="col-md-6 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Telepon
                                            </label>
                                            <input type="text" name="telepon" class="adm-input" 
                                                value="{{ old('telepon', $data->telepon) }}" maxlength="30">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Email
                                            </label>
                                            <input type="email" name="email" class="adm-input" 
                                                value="{{ old('email', $data->email) }}" maxlength="150">
                                        </div>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="adm-form-group" style="margin-bottom: 20px;">
                                    <label class="adm-form-label">
                                        Status <span class="req-star">*</span>
                                    </label>
                                    <select name="status" class="adm-select">
                                        <option value="aktif" {{ old('status', $data->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="nonaktif" {{ old('status', $data->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Form Action Area / Footer -->
                            <div class="adm-form-footer">
                                <button type="submit" class="adm-btn-submit">
                                    <i class="fas fa-save" style="font-size: 12px;"></i>
                                    <span>Simpan Perubahan</span>
                                </button>
                                <a href="{{ route('admin.operator.index') }}" class="adm-btn-cancel">
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