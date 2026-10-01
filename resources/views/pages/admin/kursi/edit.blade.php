@extends('layouts.app', ['title' => 'Edit Kursi'])

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
                    <a href="{{ route('admin.kursi.index') }}" style="color: #64748b; text-decoration: none; font-weight: 500;">Kursi</a>
                    <span style="font-size: 8px; color: #94a3b8;"><i class="fas fa-chevron-right"></i></span>
                    <span style="color: #0f172a; font-weight: 600;">Edit</span>
                </div>

                <!-- Page Title Row -->
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 42px; height: 42px; border-radius: 10px; background: #2563eb; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.22);">
                        <i class="fas fa-chair"></i>
                    </div>
                    <div>
                        <h1 style="font-size: 19px; font-weight: 700; color: #0f172a; margin: 0; line-height: 1.2; letter-spacing: -0.015em;">Edit Kursi</h1>
                        <p style="font-size: 12.5px; color: #64748b; margin: 3px 0 0 0; line-height: 1.3;">Perbarui nomor kursi, kelas tempat duduk, atau status unit</p>
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
                                <span>Form Kursi</span>
                            </div>
                            <div class="adm-form-header-note">
                                <span>Kolom bertanda</span>
                                <span class="req-star">*</span>
                                <span>wajib diisi</span>
                            </div>
                        </div>

                        <!-- Form -->
                        <form method="POST" action="{{ route('admin.kursi.update', $data->id_kursi) }}" style="margin: 0;">
                            @csrf
                            @method('PUT')
                            <div class="adm-form-body">
                                <!-- Bus & Nomor Kursi (Two Columns) -->
                                <div class="row" style="margin-left: -9px; margin-right: -9px;">
                                    <div class="col-md-6 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Armada Bus
                                            </label>
                                            <input type="text" class="adm-input"
                                                value="{{ $data->bus->nama_bus }} ({{ $data->bus->nomor_polisi }})" disabled
                                                style="background: #f8fafc; color: #64748b; cursor: not-allowed;">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Nomor Kursi <span class="req-star">*</span>
                                            </label>
                                            <input type="text" name="nomor_kursi"
                                                class="adm-input @error('nomor_kursi') is-invalid @enderror"
                                                value="{{ old('nomor_kursi', $data->nomor_kursi) }}" required maxlength="10">
                                            @error('nomor_kursi')
                                                <div class="invalid-feedback" style="font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Kelas & Harga Kursi (Two Columns) -->
                                <div class="row" style="margin-left: -9px; margin-right: -9px;">
                                    <div class="col-md-6 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Kelas Kursi <span class="req-star">*</span>
                                            </label>
                                            <select name="kelas" class="adm-select">
                                                <option value="ekonomi" {{ old('kelas', $data->kelas) == 'ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                                                <option value="bisnis" {{ old('kelas', $data->kelas) == 'bisnis' ? 'selected' : '' }}>Bisnis</option>
                                                <option value="executive" {{ old('kelas', $data->kelas) == 'executive' ? 'selected' : '' }}>Executive</option>
                                                <option value="sleeper" {{ old('kelas', $data->kelas) == 'sleeper' ? 'selected' : '' }}>Sleeper</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Tarif / Harga Kursi (Rp) <span class="req-star">*</span>
                                            </label>
                                            <input type="number" name="harga"
                                                class="adm-input @error('harga') is-invalid @enderror"
                                                value="{{ old('harga', $data->harga) }}" required min="0">
                                            @error('harga')
                                                <div class="invalid-feedback" style="font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Posisi & Status (Two Columns) -->
                                <div class="row" style="margin-left: -9px; margin-right: -9px;">
                                    <div class="col-md-6 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group" style="margin-bottom: 22px;">
                                            <label class="adm-form-label">
                                                Posisi Tempat Duduk
                                            </label>
                                            <select name="posisi" class="adm-select">
                                                <option value="jendela" {{ strtolower(old('posisi', $data->posisi)) == 'jendela' ? 'selected' : '' }}>Jendela</option>
                                                <option value="lorong" {{ strtolower(old('posisi', $data->posisi)) == 'lorong' ? 'selected' : '' }}>Lorong</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group" style="margin-bottom: 22px;">
                                            <label class="adm-form-label">
                                                Status Kursi <span class="req-star">*</span>
                                            </label>
                                            <select name="status" class="adm-select">
                                                <option value="tersedia" {{ old('status', $data->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                                <option value="rusak" {{ old('status', $data->status) == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                            </select>
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
                                <a href="{{ route('admin.kursi.index') }}" class="adm-btn-cancel">
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
