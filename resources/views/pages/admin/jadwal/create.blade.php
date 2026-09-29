@extends('layouts.app', ['title' => 'Tambah Jadwal'])

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
                    <a href="{{ route('admin.jadwal.index') }}" style="color: #64748b; text-decoration: none; font-weight: 500;">Jadwal</a>
                    <span style="font-size: 8px; color: #94a3b8;"><i class="fas fa-chevron-right"></i></span>
                    <span style="color: #0f172a; font-weight: 600;">Tambah</span>
                </div>

                <!-- Page Title Row -->
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 42px; height: 42px; border-radius: 10px; background: #2563eb; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.22);">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div>
                        <h1 style="font-size: 19px; font-weight: 700; color: #0f172a; margin: 0; line-height: 1.2; letter-spacing: -0.015em;">Tambah Jadwal</h1>
                        <p style="font-size: 12.5px; color: #64748b; margin: 3px 0 0 0; line-height: 1.3;">Jadwalkan keberangkatan bus dan tentukan tarif tiket penumpang</p>
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
                                <span>Form Jadwal</span>
                            </div>
                            <div class="adm-form-header-note">
                                <span>Kolom bertanda</span>
                                <span class="req-star">*</span>
                                <span>wajib diisi</span>
                            </div>
                        </div>

                        <!-- Form -->
                        <form method="POST" action="{{ route('admin.jadwal.store') }}" style="margin: 0;">
                            @csrf
                            <div class="adm-form-body">
                                <!-- Rute & Bus (Two Columns) -->
                                <div class="row" style="margin-left: -9px; margin-right: -9px;">
                                    <div class="col-md-6 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Pilih Rute <span class="req-star">*</span>
                                            </label>
                                            <select name="id_rute" class="adm-select @error('id_rute') is-invalid @enderror" required>
                                                <option value="">-- Pilih Rute Perjalanan --</option>
                                                @foreach ($rutes as $rute)
                                                    <option value="{{ $rute->id_rute }}" {{ old('id_rute') == $rute->id_rute ? 'selected' : '' }}>
                                                        {{ $rute->nama_rute }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('id_rute')
                                                <div class="invalid-feedback" style="font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Armada Bus <span class="req-star">*</span>
                                            </label>
                                            <select name="id_bus" class="adm-select @error('id_bus') is-invalid @enderror" required>
                                                <option value="">-- Pilih Armada Bus --</option>
                                                @foreach ($buses as $b)
                                                    <option value="{{ $b->id_bus }}" {{ old('id_bus') == $b->id_bus ? 'selected' : '' }}>
                                                        {{ $b->nama_bus }} ({{ $b->nomor_polisi }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('id_bus')
                                                <div class="invalid-feedback" style="font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Tanggal, Jam Berangkat & Jam Tiba (Three Columns) -->
                                <div class="row" style="margin-left: -9px; margin-right: -9px;">
                                    <div class="col-md-4 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Tanggal Keberangkatan <span class="req-star">*</span>
                                            </label>
                                            <input type="date" name="tanggal" class="adm-input @error('tanggal') is-invalid @enderror"
                                                value="{{ old('tanggal') }}" min="{{ now()->format('Y-m-d') }}" required>
                                            @error('tanggal')
                                                <div class="invalid-feedback" style="font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Jam Berangkat <span class="req-star">*</span>
                                            </label>
                                            <input type="time" name="jam_berangkat" class="adm-input @error('jam_berangkat') is-invalid @enderror"
                                                value="{{ old('jam_berangkat') }}" required>
                                            @error('jam_berangkat')
                                                <div class="invalid-feedback" style="font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group">
                                            <label class="adm-form-label">
                                                Jam Tiba (Estimasi)
                                            </label>
                                            <input type="time" name="jam_tiba" class="adm-input" value="{{ old('jam_tiba') }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Harga Tiket & Status (Two Columns) -->
                                <div class="row" style="margin-left: -9px; margin-right: -9px;">
                                    <div class="col-md-6 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group" style="margin-bottom: 22px;">
                                            <label class="adm-form-label">
                                                Tarif / Harga Tiket (Rp) <span class="req-star">*</span>
                                            </label>
                                            <input type="number" name="harga" class="adm-input @error('harga') is-invalid @enderror"
                                                value="{{ old('harga') }}" min="0" required
                                                placeholder="Contoh: 150000">
                                            @error('harga')
                                                <div class="invalid-feedback" style="font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12" style="padding-left: 9px; padding-right: 9px;">
                                        <div class="adm-form-group" style="margin-bottom: 22px;">
                                            <label class="adm-form-label">
                                                Status Jadwal <span class="req-star">*</span>
                                            </label>
                                            <select name="status" class="adm-select">
                                                <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                                <option value="penuh" {{ old('status') == 'penuh' ? 'selected' : '' }}>Penuh</option>
                                                <option value="berangkat" {{ old('status') == 'berangkat' ? 'selected' : '' }}>Berangkat</option>
                                                <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                                <option value="dibatalkan" {{ old('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Action Area / Footer -->
                            <div class="adm-form-footer">
                                <button type="submit" class="adm-btn-submit">
                                    <i class="fas fa-save" style="font-size: 12px;"></i>
                                    <span>Simpan Jadwal</span>
                                </button>
                                <a href="{{ route('admin.jadwal.index') }}" class="adm-btn-cancel">
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