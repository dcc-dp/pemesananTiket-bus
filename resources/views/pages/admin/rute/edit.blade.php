@extends('layouts.app', ['title' => 'Edit Rute'])

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
                    <a href="{{ route('admin.rute.index') }}" style="color: #64748b; text-decoration: none; font-weight: 500;">Rute</a>
                    <span style="font-size: 8px; color: #94a3b8;"><i class="fas fa-chevron-right"></i></span>
                    <span style="color: #0f172a; font-weight: 600;">Edit</span>
                </div>

                <!-- Page Title Row -->
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 42px; height: 42px; border-radius: 10px; background: #2563eb; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.22);">
                        <i class="fas fa-route"></i>
                    </div>
                    <div>
                        <h1 style="font-size: 19px; font-weight: 700; color: #0f172a; margin: 0; line-height: 1.2; letter-spacing: -0.015em;">Edit Rute</h1>
                        <p style="font-size: 12.5px; color: #64748b; margin: 3px 0 0 0; line-height: 1.3;">Perbarui informasi jarak, durasi, dan status lintasan rute</p>
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
                                <span>Form Rute</span>
                            </div>
                            <div class="adm-form-header-note">
                                <span>Kolom bertanda</span>
                                <span class="req-star">*</span>
                                <span>wajib diisi</span>
                            </div>
                        </div>

                        <!-- Form -->
                        <form method="POST" action="{{ route('admin.rute.update', $data->id_rute) }}" style="margin: 0;">
                            @csrf
                            @method('PUT')
                            <div class="adm-form-body">
                                <!-- Terminal Asal & Tujuan (Two Columns) -->
                                <div class="row" style="margin-left: -9px; margin-right: -9px;">
                                    <div class="col-md-6 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Terminal Asal <span class="req-star">*</span>
                                            </label>
                                            <select name="terminal_asal_id" class="adm-select @error('terminal_asal_id') is-invalid @enderror" required>
                                                <option value="">-- Pilih Terminal Asal --</option>
                                                @foreach ($terminals as $terminal)
                                                    <option value="{{ $terminal->id_terminal }}" {{ old('terminal_asal_id', $data->terminal_asal_id) == $terminal->id_terminal ? 'selected' : '' }}>
                                                        {{ $terminal->kota }} - {{ $terminal->nama_terminal }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('terminal_asal_id')
                                                <div class="invalid-feedback" style="font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Terminal Tujuan <span class="req-star">*</span>
                                            </label>
                                            <select name="terminal_tujuan_id" class="adm-select @error('terminal_tujuan_id') is-invalid @enderror" required>
                                                <option value="">-- Pilih Terminal Tujuan --</option>
                                                @foreach ($terminals as $terminal)
                                                    <option value="{{ $terminal->id_terminal }}" {{ old('terminal_tujuan_id', $data->terminal_tujuan_id) == $terminal->id_terminal ? 'selected' : '' }}>
                                                        {{ $terminal->kota }} - {{ $terminal->nama_terminal }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('terminal_tujuan_id')
                                                <div class="invalid-feedback" style="font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Jarak, Durasi & Status (Three Columns) -->
                                <div class="row" style="margin-left: -9px; margin-right: -9px;">
                                    <div class="col-md-4 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Jarak (km)
                                            </label>
                                            <input type="number" name="jarak" class="adm-input" value="{{ old('jarak', $data->jarak) }}" min="0" step="0.1">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Estimasi Durasi (menit)
                                            </label>
                                            <input type="number" name="estimasi_durasi" class="adm-input" value="{{ old('estimasi_durasi', $data->estimasi_durasi) }}" min="1">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Status Rute <span class="req-star">*</span>
                                            </label>
                                            <select name="status" class="adm-select">
                                                <option value="aktif" {{ old('status', $data->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                <option value="nonaktif" {{ old('status', $data->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
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
                                <a href="{{ route('admin.rute.index') }}" class="adm-btn-cancel">
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