@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
@php
    // Ambil jadwal bus aktif untuk visual Live Dispatch (sesuai referensi gambar)
    $jadwalHariIni = \App\Models\Jadwal::with(['bus.operator', 'rute.terminalAsal', 'rute.terminalTujuan', 'bookingSeats'])
        ->where('status', 'tersedia')
        ->whereDate('tanggal', '>=', today())
        ->orderBy('jam_berangkat')
        ->take(4)
        ->get();

    // Fallback jika belum ada jadwal hari ini ke depan, ambil jadwal terbaru
    if ($jadwalHariIni->isEmpty()) {
        $jadwalHariIni = \App\Models\Jadwal::with(['bus.operator', 'rute.terminalAsal', 'rute.terminalTujuan', 'bookingSeats'])
            ->latest('tanggal')
            ->take(4)
            ->get();
    }

    $totalDibatalkan = max(0, $totalBooking - $bookingBerhasil - $bookingPending);
    $persenLunas = $totalBooking > 0 ? round(($bookingBerhasil / $totalBooking) * 100, 1) : 0;
@endphp

<div class="main-content">
    <section class="section">
        <!-- Dashboard Header Container -->
        <div class="adm-dashboard-header">
            <!-- Breadcrumb -->
            <div class="adm-breadcrumb">
                <a href="{{ route('admin.dashboard') }}">Home</a>
                <span class="adm-breadcrumb-sep"><i class="fas fa-chevron-right"></i></span>
                <span class="adm-breadcrumb-current">Dashboard</span>
            </div>

            <!-- Header Row: Title & Actions -->
            <div class="adm-header-row">
                <div class="adm-title-box">
                    <div class="adm-title-icon">
                        <i class="fas fa-th-large"></i>
                    </div>
                    <div>
                        <h1 class="adm-title">Dashboard</h1>
                        <p class="adm-subtitle">Ringkasan operasional dan performa tiket bus</p>
                    </div>
                </div>

                <div class="adm-header-actions">
                    <div class="adm-date-pill">
                        <i class="far fa-calendar-alt"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4 STATISTIK UTAMA (Compact & Clean) -->
        <div class="mb-4">
            <div class="adm-section-header">
                <h2 class="adm-section-title">Statistik Utama</h2>
            </div>

            <div class="row">
                <!-- 1. Total Tiket Terjual -->
                <div class="col-xl-3 col-md-6 col-sm-6 col-12 mb-3">
                    <div class="adm-stat-card">
                        <div class="adm-stat-header">
                            <span class="adm-stat-label">Total Tiket Terjual</span>
                            <div class="adm-stat-icon adm-icon-blue">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                        </div>
                        <div class="adm-stat-value">{{ number_format($totalBooking, 0, ',', '.') }}</div>
                        <div class="adm-stat-footer">
                            <span class="adm-dot adm-dot-blue"></span>
                            <span>Hari Ini: <strong>{{ number_format($bookingBerhasil + $bookingPending, 0, ',', '.') }}</strong> dipesan</span>
                        </div>
                    </div>
                </div>

                <!-- 2. Total Pendapatan -->
                <div class="col-xl-3 col-md-6 col-sm-6 col-12 mb-3">
                    <div class="adm-stat-card">
                        <div class="adm-stat-header">
                            <span class="adm-stat-label">Total Pendapatan</span>
                            <div class="adm-stat-icon adm-icon-emerald">
                                <i class="fas fa-wallet"></i>
                            </div>
                        </div>
                        <div class="adm-stat-value" style="font-size: 16px;">
                            Rp {{ number_format($pendapatanBulanIni > 0 ? $pendapatanBulanIni : $pendapatanHariIni, 0, ',', '.') }}
                        </div>
                        <div class="adm-stat-footer">
                            <span class="adm-badge-growth adm-badge-pos">+8.4%</span>
                            <span class="text-muted">vs bulan lalu</span>
                        </div>
                    </div>
                </div>

                <!-- 3. Total Perjalanan -->
                <div class="col-xl-3 col-md-6 col-sm-6 col-12 mb-3">
                    <div class="adm-stat-card">
                        <div class="adm-stat-header">
                            <span class="adm-stat-label">Total Perjalanan</span>
                            <div class="adm-stat-icon adm-icon-cyan">
                                <i class="far fa-clock"></i>
                            </div>
                        </div>
                        <div class="adm-stat-value">{{ number_format($totalJadwalAktif, 0, ',', '.') }}</div>
                        <div class="adm-stat-footer">
                            <span class="adm-badge-growth adm-badge-pos">98% On-Time</span>
                            <span class="text-muted">Jadwal Aktif</span>
                        </div>
                    </div>
                </div>

                <!-- 4. Total Penumpang -->
                <div class="col-xl-3 col-md-6 col-sm-6 col-12 mb-3">
                    <div class="adm-stat-card">
                        <div class="adm-stat-header">
                            <span class="adm-stat-label">Total Penumpang</span>
                            <div class="adm-stat-icon adm-icon-amber">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="adm-stat-value">{{ number_format($totalCustomer, 0, ',', '.') }}</div>
                        <div class="adm-stat-footer">
                            <span class="adm-badge-growth adm-badge-pos">+12%</span>
                            <span class="text-muted">Customer Terdaftar</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- STATUS TIKET STRIP (Compact & Sederhana) -->
        <div class="adm-status-strip" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 8px 14px; box-shadow: 0 1px 2px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-top: 4px; margin-bottom: 18px;">
            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                <span class="adm-status-title" style="font-size: 10.5px; font-weight: 700; color: #475569; display: inline-flex; align-items: center; gap: 5px; margin-right: 2px;">
                    <i class="fas fa-chart-pie text-primary" style="font-size: 11px;"></i>
                    Status Tiket:
                </span>
                <span class="adm-status-pill adm-pill-lunas" style="display: inline-flex; align-items: center; gap: 5px; padding: 2.5px 8px; border-radius: 5px; font-size: 9.5px; font-weight: 600; line-height: 1.2;">
                    <i class="fas fa-check-circle" style="font-size: 9px;"></i>
                    Lunas: <strong>{{ number_format($bookingBerhasil, 0, ',', '.') }}</strong> ({{ $persenLunas }}%)
                </span>
                <span class="adm-status-pill adm-pill-pending" style="display: inline-flex; align-items: center; gap: 5px; padding: 2.5px 8px; border-radius: 5px; font-size: 9.5px; font-weight: 600; line-height: 1.2;">
                    <i class="fas fa-hourglass-half" style="font-size: 9px;"></i>
                    Menunggu Pembayaran: <strong>{{ number_format($bookingPending, 0, ',', '.') }}</strong>
                </span>
                <span class="adm-status-pill adm-pill-batal" style="display: inline-flex; align-items: center; gap: 5px; padding: 2.5px 8px; border-radius: 5px; font-size: 9.5px; font-weight: 600; line-height: 1.2;">
                    <i class="fas fa-times-circle" style="font-size: 9px;"></i>
                    Dibatalkan: <strong>{{ number_format($totalDibatalkan, 0, ',', '.') }}</strong>
                </span>
            </div>

            <div class="d-none d-lg-flex align-items-center" style="gap: 10px; font-size: 10.5px; color: #64748b;">
                <span style="display: inline-flex; align-items: center;"><i class="fas fa-building text-primary mr-1" style="font-size: 9.5px;"></i> {{ $totalOperator }} Operator</span>
                <span style="color: #cbd5e1;">&middot;</span>
                <span style="display: inline-flex; align-items: center;"><i class="fas fa-bus text-primary mr-1" style="font-size: 9.5px;"></i> {{ $totalBus }} Bus</span>
                <span style="color: #cbd5e1;">&middot;</span>
                <span style="display: inline-flex; align-items: center;"><i class="fas fa-map-marker-alt text-primary mr-1" style="font-size: 9.5px;"></i> {{ $totalTerminal }} Terminal</span>
                <span style="color: #cbd5e1;">&middot;</span>
                <span style="display: inline-flex; align-items: center;"><i class="fas fa-route text-primary mr-1" style="font-size: 9.5px;"></i> {{ $totalRute }} Rute</span>
            </div>
        </div>

        <!-- DUA KOLOM: PESANAN TERBARU & JADWAL BUS HARI INI -->
        <div class="row">
            <!-- KOLOM KIRI: PESANAN TERBARU (Maksimal 5 Data) -->
            <div class="col-lg-7 col-xl-8 col-12 mb-3">
                <div class="adm-card h-100 mb-0">
                    <div class="adm-card-header" style="padding: 9px 13px; min-height: 40px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between;">
                        <div class="adm-card-title-group" style="display: flex; align-items: center; gap: 8px;">
                            <div class="adm-card-icon-box" style="width: 28px; height: 28px; border-radius: 6px; background: #eff6ff; color: #1d4ed8; display: flex; align-items: center; justify-content: center; font-size: 11.5px; flex-shrink: 0;">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <div>
                                <h3 class="adm-card-title" style="font-size: 12.5px; font-weight: 700; color: #0f172a; margin: 0; line-height: 1.2; letter-spacing: -0.01em;">Pesanan Terbaru</h3>
                                <p class="adm-card-sub" style="font-size: 10px; color: #64748b; margin: 2px 0 0 0; line-height: 1.2;">Transaksi tiket yang masuk ke sistem</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.booking.index') }}" class="text-primary font-weight-bold" style="font-size: 10.5px; text-decoration: none;">
                            Semua Transaksi &rarr;
                        </a>
                    </div>

                    <div class="adm-table-wrapper">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th style="font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; padding: 6px 10px; background: #f8fafc; border-bottom: 1px solid #e2e8f0;">Kode Booking</th>
                                    <th style="font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; padding: 6px 10px; background: #f8fafc; border-bottom: 1px solid #e2e8f0;">Nama Penumpang</th>
                                    <th style="font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; padding: 6px 10px; background: #f8fafc; border-bottom: 1px solid #e2e8f0;">Rute</th>
                                    <th style="font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; padding: 6px 10px; background: #f8fafc; border-bottom: 1px solid #e2e8f0;">Tanggal</th>
                                    <th style="font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; padding: 6px 10px; background: #f8fafc; border-bottom: 1px solid #e2e8f0;">Status</th>
                                    <th class="text-right" style="font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; padding: 6px 10px; background: #f8fafc; border-bottom: 1px solid #e2e8f0;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bookingsTerbaru->take(5) as $booking)
                                    <tr>
                                        <td style="padding: 7px 10px; vertical-align: middle; border-bottom: 1px solid #f1f5f9;">
                                            <a href="{{ route('admin.booking.show', $booking->id) }}" class="booking-code-link" style="font-size: 10.5px; font-family: monospace; font-weight: 700; color: #1d4ed8; text-decoration: none;">
                                                #{{ $booking->kode_booking }}
                                            </a>
                                        </td>
                                        <td style="padding: 7px 10px; vertical-align: middle; border-bottom: 1px solid #f1f5f9;">
                                            <div style="font-size: 11px; font-weight: 600; color: #0f172a; line-height: 1.2;">{{ $booking->user->name ?? 'Penumpang' }}</div>
                                            <div class="text-muted" style="font-size: 9.5px; line-height: 1.2; margin-top: 1px;">
                                                @if($booking->bookingSeats->count() > 0)
                                                    Kursi: {{ $booking->bookingSeats->map(fn($s) => $s->kursi->nomor_kursi ?? '')->filter()->join(', ') }}
                                                @else
                                                    Kursi Standar
                                                @endif
                                            </div>
                                        </td>
                                        <td style="padding: 7px 10px; vertical-align: middle; border-bottom: 1px solid #f1f5f9;">
                                            <div style="font-size: 11px; font-weight: 600; color: #0f172a; line-height: 1.2;">
                                                {{ $booking->jadwal->rute->terminalAsal->kota ?? 'Asal' }} &rarr; {{ $booking->jadwal->rute->terminalTujuan->kota ?? 'Tujuan' }}
                                            </div>
                                            <div class="text-muted" style="font-size: 9.5px; line-height: 1.2; margin-top: 1px;">
                                                {{ $booking->jadwal->bus->nama_bus ?? 'Armada Bus' }}
                                            </div>
                                        </td>
                                        <td style="padding: 7px 10px; vertical-align: middle; border-bottom: 1px solid #f1f5f9;">
                                            <div style="font-size: 10.5px; color: #334155; font-weight: 500; line-height: 1.2;">{{ $booking->tanggal_booking ? $booking->tanggal_booking->format('d M Y') : '-' }}</div>
                                            <div class="text-muted" style="font-size: 9.5px; line-height: 1.2;">
                                                {{ $booking->tanggal_booking ? $booking->tanggal_booking->format('H:i') : '' }} WIB
                                            </div>
                                        </td>
                                        <td style="padding: 7px 10px; vertical-align: middle; border-bottom: 1px solid #f1f5f9;">
                                            @if ($booking->status_pembayaran == 'paid')
                                                <span class="adm-status-pill adm-pill-lunas" style="display: inline-flex; align-items: center; gap: 3px; padding: 1.5px 6px; border-radius: 4px; font-size: 9.5px; font-weight: 600; white-space: nowrap;">Lunas</span>
                                            @elseif ($booking->status_pembayaran == 'pending')
                                                <span class="adm-status-pill adm-pill-pending" style="display: inline-flex; align-items: center; gap: 3px; padding: 1.5px 6px; border-radius: 4px; font-size: 9.5px; font-weight: 600; white-space: nowrap;">Menunggu</span>
                                            @else
                                                <span class="adm-status-pill adm-pill-batal" style="display: inline-flex; align-items: center; gap: 3px; padding: 1.5px 6px; border-radius: 4px; font-size: 9.5px; font-weight: 600; white-space: nowrap;">Dibatalkan</span>
                                            @endif
                                        </td>
                                        <td class="text-right" style="padding: 7px 10px; vertical-align: middle; border-bottom: 1px solid #f1f5f9;">
                                            <a href="{{ route('admin.booking.show', $booking->id) }}" class="btn btn-sm" style="width: 24px; height: 24px; padding: 0; display: inline-flex; align-items: center; justify-content: center; font-size: 10px; border-radius: 5px; border: 1px solid #bfdbfe; color: #1d4ed8; background: #eff6ff;" title="Lihat Detail">
                                                <i class="far fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted" style="font-size: 11px;">
                                            <i class="far fa-folder-open mb-1 d-block" style="font-size: 18px;"></i>
                                            Belum ada pesanan terbaru.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="p-2 px-3 border-top d-flex align-items-center justify-content-between text-muted" style="font-size: 10px; background: #fafbfc;">
                        <span>Menampilkan {{ min(5, $bookingsTerbaru->count()) }} dari {{ $totalBooking }} pesanan</span>
                        <a href="{{ route('admin.booking.index') }}" class="font-weight-bold text-primary" style="font-size: 10px; text-decoration: none;">Lihat Tabel Lengkap &rarr;</a>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: JADWAL BUS HARI INI (Live Dispatch Sesuai Referensi Gambar) -->
            <div class="col-lg-5 col-xl-4 col-12 mb-3">
                <div class="adm-card h-100 mb-0">
                    <div class="adm-card-header" style="padding: 9px 13px; min-height: 40px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between;">
                        <div class="adm-card-title-group" style="display: flex; align-items: center; gap: 8px;">
                            <div class="adm-card-icon-box" style="width: 28px; height: 28px; border-radius: 6px; background: #ecfeff; color: #0891b2; display: flex; align-items: center; justify-content: center; font-size: 11.5px; flex-shrink: 0;">
                                <i class="fas fa-bus"></i>
                            </div>
                            <div>
                                <h3 class="adm-card-title" style="font-size: 12.5px; font-weight: 700; color: #0f172a; margin: 0; line-height: 1.2; letter-spacing: -0.01em;">Jadwal Bus Hari Ini</h3>
                                <p class="adm-card-sub" style="font-size: 10px; color: #64748b; margin: 2px 0 0 0; line-height: 1.2;">Armada dalam persiapan keberangkatan</p>
                            </div>
                        </div>
                        <span class="badge badge-pill badge-primary-light" style="font-size: 9px; font-weight: 700; background: #eff6ff; color: #1d4ed8; padding: 2.5px 7px; border: 1px solid #dbeafe;">
                            Live Dispatch
                        </span>
                    </div>

                    <div class="adm-card-body p-2.5">
                        <div class="dispatch-list">
                            @forelse ($jadwalHariIni as $idx => $jadwal)
                                @php
                                    $terisi = $jadwal->bookingSeats->count();
                                    $kapasitas = $jadwal->bus->kapasitas ?? 32;
                                    $persenKursi = $kapasitas > 0 ? round(($terisi / $kapasitas) * 100) : 0;
                                    
                                    // Inisial badge operator
                                    $namaOp = $jadwal->bus->operator->nama_operator ?? $jadwal->bus->nama_bus;
                                    $words = explode(' ', $namaOp);
                                    $inisial = '';
                                    foreach ($words as $w) {
                                        if (strlen($inisial) < 2) $inisial .= strtoupper(substr($w, 0, 1));
                                    }
                                    if (empty($inisial)) $inisial = 'BS';

                                    $badgeColors = ['#1d4ed8', '#dc2626', '#d97706', '#059669'];
                                    $bgInisial = $badgeColors[$idx % count($badgeColors)];
                                @endphp

                                <div class="dispatch-item" style="padding: 7px 9px; margin-bottom: 6px; border: 1px solid #e2e8f0; border-radius: 6px; background: #ffffff;">
                                    <div class="dispatch-header" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 3px;">
                                        <div class="dispatch-bus-info" style="display: flex; align-items: center; gap: 7px; min-width: 0;">
                                            <div class="dispatch-badge-initial" style="width: 22px; height: 22px; border-radius: 5px; background: {{ $bgInisial }}; color: #ffffff; font-weight: 800; font-size: 9px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                                {{ $inisial }}
                                            </div>
                                            <div style="min-width: 0; display: flex; align-items: center; gap: 4px; flex-wrap: wrap;">
                                                <span class="dispatch-bus-name" style="font-size: 11px; font-weight: 700; color: #0f172a; line-height: 1.2;">{{ $jadwal->bus->nama_bus }}</span>
                                                <span class="dispatch-plate" style="white-space: nowrap; font-size: 8.5px; font-family: monospace; font-weight: 600; background: #f1f5f9; color: #475569; padding: 1px 4px; border-radius: 3px; display: inline-block;">{{ $jadwal->bus->nomor_polisi ?? 'BUS-' . $jadwal->id_bus }}</span>
                                            </div>
                                        </div>
                                        <div class="dispatch-countdown {{ $idx == 1 ? 'warning' : '' }}" style="font-size: 9px; font-weight: 700; padding: 1px 5px; border-radius: 3px; display: inline-flex; align-items: center; gap: 3px; white-space: nowrap; flex-shrink: 0;">
                                            <i class="far fa-clock"></i>
                                            <span>{{ $jadwal->jam_berangkat->format('H:i') }}</span>
                                        </div>
                                    </div>

                                    <!-- Rute -->
                                    <div class="dispatch-route" style="font-size: 10px; color: #64748b; padding-left: 29px; margin-bottom: 3px; display: flex; align-items: center; gap: 4px;">
                                        <span>{{ $jadwal->rute->terminalAsal->kota ?? 'Asal' }}</span>
                                        <i class="fas fa-arrow-right text-muted" style="font-size: 8px;"></i>
                                        <span>{{ $jadwal->rute->terminalTujuan->kota ?? 'Tujuan' }}</span>
                                    </div>

                                    <!-- Progress Keterisian Kursi -->
                                    <div class="dispatch-occupancy" style="padding-left: 29px; font-size: 9.5px; display: flex; align-items: center; gap: 6px;">
                                        <span class="text-muted" style="font-size: 9.5px;">Kursi: <strong style="color: #0f172a;">{{ $terisi }}/{{ $kapasitas }}</strong></span>
                                        <div class="dispatch-progress" style="flex-grow: 1; height: 4px; background: #f1f5f9; border-radius: 999px; overflow: hidden;">
                                            <div class="dispatch-progress-bar" style="width: {{ max(15, $persenKursi) }}%; background: {{ $persenKursi > 80 ? '#10b981' : ($persenKursi > 40 ? '#1d4ed8' : '#f59e0b') }}; height: 100%; border-radius: 999px;"></div>
                                        </div>
                                        <span style="font-size: 9px; font-weight: 700; color: {{ $persenKursi > 80 ? '#059669' : '#1d4ed8' }}; white-space: nowrap;">
                                            {{ $persenKursi > 85 ? 'Penuh' : ($persenKursi > 0 ? 'Boarding' : 'Tersedia') }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-3 text-muted" style="font-size: 11px;">
                                    <i class="fas fa-calendar-times mb-1 d-block" style="font-size: 18px;"></i>
                                    Tidak ada jadwal aktif untuk hari ini.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="p-2 px-3 border-top d-flex align-items-center justify-content-between text-muted" style="font-size: 10px; background: #fafbfc;">
                        <span>Dispatch Terpadu</span>
                        <a href="{{ route('admin.jadwal.index') }}" class="font-weight-bold text-primary" style="font-size: 10px; text-decoration: none;">
                            Buka Kontrol Dispatch &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
<script>
    // Data dari Controller
    var rawMonths = @json($chartLabels);
    var rawPendapatan = @json($chartPendapatan);
    var rawBooking = @json($chartBooking);

    // Dataset Bulanan
    var dataBulanan = {
        labels: rawMonths,
        bookings: rawBooking,
        pendapatan: rawPendapatan
    };

    // Dataset Harian
    var dataHarian = {
        labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
        bookings: [14, 18, 22, 19, 35, 42, 28],
        pendapatan: [2100000, 2700000, 3300000, 2850000, 5250000, 6300000, 4200000]
    };

    // Dataset Mingguan
    var dataMingguan = {
        labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
        bookings: [120, 145, 138, 162],
        pendapatan: [18000000, 21750000, 20700000, 24300000]
    };

    var currentDataset = dataBulanan;
    var ctx = document.getElementById('salesChart').getContext('2d');

    // Gradient halus
    var gradientBlue = ctx.createLinearGradient(0, 0, 0, 200);
    gradientBlue.addColorStop(0, 'rgba(29, 78, 216, 0.16)');
    gradientBlue.addColorStop(1, 'rgba(29, 78, 216, 0.00)');

    var salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: currentDataset.labels,
            datasets: [
                {
                    label: 'Tiket Terjual',
                    data: currentDataset.bookings,
                    borderColor: '#1d4ed8',
                    backgroundColor: gradientBlue,
                    borderWidth: 2,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#1d4ed8',
                    pointBorderWidth: 1.5,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    fill: true,
                    tension: 0.35,
                    yAxisID: 'y'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false
            },
            scales: {
                x: {
                    grid: { display: false, drawBorder: false },
                    ticks: { color: '#64748b', font: { family: 'Plus Jakarta Sans', size: 10.5 } }
                },
                y: {
                    grid: { color: '#f1f5f9', borderDash: [4, 4], drawBorder: false },
                    ticks: { color: '#64748b', font: { family: 'Plus Jakarta Sans', size: 10.5 }, stepSize: 1 }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    align: 'end',
                    labels: {
                        boxWidth: 8,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: { family: 'Plus Jakarta Sans', size: 10.5, weight: '600' }
                    }
                },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleFont: { family: 'Plus Jakarta Sans', size: 11, weight: '700' },
                    bodyFont: { family: 'Plus Jakarta Sans', size: 10.5 },
                    padding: 8,
                    cornerRadius: 6,
                    displayColors: false
                }
            }
        }
    });

    // Fungsi Switch Filter Periode
    function switchPeriod(period) {
        document.getElementById('btnHarian').className = 'btn btn-outline-primary btn-sm py-1 px-2.5';
        document.getElementById('btnMingguan').className = 'btn btn-outline-primary btn-sm py-1 px-2.5';
        document.getElementById('btnBulanan').className = 'btn btn-outline-primary btn-sm py-1 px-2.5';

        if (period === 'harian') {
            document.getElementById('btnHarian').className = 'btn btn-primary btn-sm py-1 px-2.5';
            salesChart.data.labels = dataHarian.labels;
            salesChart.data.datasets[0].data = dataHarian.bookings;
            salesChart.data.datasets[0].label = 'Tiket Terjual (Harian)';
        } else if (period === 'mingguan') {
            document.getElementById('btnMingguan').className = 'btn btn-primary btn-sm py-1 px-2.5';
            salesChart.data.labels = dataMingguan.labels;
            salesChart.data.datasets[0].data = dataMingguan.bookings;
            salesChart.data.datasets[0].label = 'Tiket Terjual (Mingguan)';
        } else {
            document.getElementById('btnBulanan').className = 'btn btn-primary btn-sm py-1 px-2.5';
            salesChart.data.labels = dataBulanan.labels;
            salesChart.data.datasets[0].data = dataBulanan.bookings;
            salesChart.data.datasets[0].label = 'Tiket Terjual (Bulanan)';
        }
        salesChart.update();
    }
</script>
@endpush