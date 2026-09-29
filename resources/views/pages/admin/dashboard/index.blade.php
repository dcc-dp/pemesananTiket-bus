@extends('layouts.app', ['title' => 'Dashboard', 'menu' => 'dashboard'])

@section('content')
    <div class="main-content">
        <section class="section">
            
            <!-- Page Header -->
            <div class="section-header">
                <div class="d-flex align-items-center">
                    <div class="header-icon-box mr-3">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">grid_view</span>
                    </div>
                    <div>
                        <h1 class="mb-0">Dashboard</h1>
                        <div class="header-subtitle">Ringkasan operasional dan performa tiket bus real-time</div>
                    </div>
                </div>

                <div class="d-flex align-items-center flex-wrap gap-2 mt-2 mt-sm-0">
                    <!-- Date Pill -->
                    <div class="header-date-pill mr-2">
                        <span class="material-symbols-outlined">calendar_today</span>
                        <span>{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</span>
                    </div>

                    <!-- Refresh Button -->
                    <button type="button" class="btn btn-primary" onclick="window.location.reload();">
                        <span class="material-symbols-outlined" style="font-size: 16px;">refresh</span>
                        <span>Refresh Data</span>
                    </button>
                </div>
            </div>

            <!-- SECTION 1: Operasional & Armada -->
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h2 class="dashboard-section-title mb-0">Operasional &amp; Armada</h2>
                <span class="dashboard-section-sub">Update: 2 menit lalu</span>
            </div>

            <div class="row mb-4">
                <!-- 1. Operator -->
                <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12 mb-3 mb-xl-0">
                    <div class="modern-stat-card">
                        <div class="stat-card-top">
                            <span class="stat-card-label">Operator</span>
                            <div class="stat-icon-box stat-icon-blue">
                                <span class="material-symbols-outlined">domain</span>
                            </div>
                        </div>
                        <div class="stat-card-number">{{ $totalOperator }}</div>
                        <div class="stat-card-footer">
                            <span>Operator Mitra Aktif</span>
                        </div>
                    </div>
                </div>

                <!-- 2. Bus -->
                <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12 mb-3 mb-xl-0">
                    <div class="modern-stat-card">
                        <div class="stat-card-top">
                            <span class="stat-card-label">Bus</span>
                            <div class="stat-icon-box stat-icon-indigo">
                                <span class="material-symbols-outlined">directions_bus</span>
                            </div>
                        </div>
                        <div class="stat-card-number">{{ $totalBus }}</div>
                        <div class="stat-card-footer">
                            <span>Total Armada Bus</span>
                        </div>
                    </div>
                </div>

                <!-- 3. Terminal -->
                <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12 mb-3 mb-xl-0">
                    <div class="modern-stat-card">
                        <div class="stat-card-top">
                            <span class="stat-card-label">Terminal</span>
                            <div class="stat-icon-box stat-icon-emerald">
                                <span class="material-symbols-outlined">location_on</span>
                            </div>
                        </div>
                        <div class="stat-card-number">{{ $totalTerminal }}</div>
                        <div class="stat-card-footer">
                            <span>Terminal &amp; Titik Jemput</span>
                        </div>
                    </div>
                </div>

                <!-- 4. Rute -->
                <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12 mb-3 mb-xl-0">
                    <div class="modern-stat-card">
                        <div class="stat-card-top">
                            <span class="stat-card-label">Rute</span>
                            <div class="stat-icon-box stat-icon-violet">
                                <span class="material-symbols-outlined">alt_route</span>
                            </div>
                        </div>
                        <div class="stat-card-number">{{ $totalRute }}</div>
                        <div class="stat-card-footer">
                            <span>Antar Kota &amp; Provinsi</span>
                        </div>
                    </div>
                </div>

                <!-- 5. Jadwal Aktif -->
                <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12 mb-3 mb-xl-0">
                    <div class="modern-stat-card">
                        <div class="stat-card-top">
                            <span class="stat-card-label">Jadwal Aktif</span>
                            <div class="stat-icon-box stat-icon-cyan">
                                <span class="material-symbols-outlined">schedule</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-baseline gap-2">
                            <div class="stat-card-number">{{ $totalJadwalAktif }}</div>
                            <span class="stat-badge stat-badge-success ml-2">98% On-Time</span>
                        </div>
                        <div class="stat-card-footer">
                            <span>Keberangkatan Hari Ini</span>
                        </div>
                    </div>
                </div>

                <!-- 6. Customer -->
                <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12 mb-3 mb-xl-0">
                    <div class="modern-stat-card">
                        <div class="stat-card-top">
                            <span class="stat-card-label">Customer</span>
                            <div class="stat-icon-box stat-icon-amber">
                                <span class="material-symbols-outlined">group</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-baseline gap-2">
                            <div class="stat-card-number">{{ number_format($totalCustomer) }}</div>
                            <span class="stat-badge stat-badge-success ml-2">+12%</span>
                        </div>
                        <div class="stat-card-footer">
                            <span>Pengguna Terdaftar</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: Pemesanan & Finansial -->
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h2 class="dashboard-section-title mb-0">Pemesanan &amp; Finansial</h2>
                <a href="{{ route('admin.report.index') }}" class="font-weight-bold text-primary" style="font-size: 12.5px;">
                    Lihat Rincian Keuangan &rarr;
                </a>
            </div>

            <div class="row mb-4">
                <!-- 1. Total Booking -->
                <div class="col-xl col-lg-4 col-md-6 col-12 mb-3 mb-xl-0">
                    <div class="modern-stat-card">
                        <div class="stat-card-top">
                            <span class="stat-card-label">Total Booking</span>
                            <div class="stat-icon-box stat-icon-blue">
                                <span class="material-symbols-outlined">confirmation_number</span>
                            </div>
                        </div>
                        <div class="stat-card-number">{{ number_format($totalBooking) }}</div>
                        <div class="stat-card-footer">
                            <span class="text-primary font-weight-bold">&bull;</span>
                            <span>Tiket Dipesan Hari Ini</span>
                        </div>
                    </div>
                </div>

                <!-- 2. Booking Pending -->
                <div class="col-xl col-lg-4 col-md-6 col-12 mb-3 mb-xl-0">
                    <div class="modern-stat-card">
                        <div class="stat-card-top">
                            <span class="stat-card-label">Booking Pending</span>
                            <div class="stat-icon-box stat-icon-amber">
                                <span class="material-symbols-outlined">hourglass_top</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-baseline gap-2">
                            <div class="stat-card-number">{{ $bookingPending }}</div>
                            <span class="stat-badge stat-badge-warning ml-2">Menunggu Bayar</span>
                        </div>
                        <div class="stat-card-footer">
                            <span>Batas 15 menit tersisa</span>
                        </div>
                    </div>
                </div>

                <!-- 3. Booking Lunas -->
                <div class="col-xl col-lg-4 col-md-6 col-12 mb-3 mb-xl-0">
                    <div class="modern-stat-card">
                        <div class="stat-card-top">
                            <span class="stat-card-label">Booking Lunas</span>
                            <div class="stat-icon-box stat-icon-emerald">
                                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-baseline gap-2">
                            <div class="stat-card-number">{{ number_format($bookingBerhasil) }}</div>
                            <span class="stat-badge stat-badge-success ml-2">96.7% Terverifikasi</span>
                        </div>
                        <div class="stat-card-footer">
                            <span>E-Tiket &amp; Barcode Aktif</span>
                        </div>
                    </div>
                </div>

                <!-- 4. Pendapatan Hari Ini (Highlighted) -->
                <div class="col-xl col-lg-6 col-md-6 col-12 mb-3 mb-xl-0">
                    <div class="modern-stat-card highlight-blue">
                        <div class="stat-card-top">
                            <span class="stat-card-label blue">Pendapatan Hari Ini</span>
                            <div class="stat-icon-box stat-icon-solid-blue">
                                <span class="material-symbols-outlined">payments</span>
                            </div>
                        </div>
                        <div class="stat-card-number" style="color: #1d4ed8;">
                            Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}
                        </div>
                        <div class="stat-card-footer">
                            <span class="stat-badge stat-badge-success">+8.4%</span>
                            <span>vs kemarin</span>
                        </div>
                    </div>
                </div>

                <!-- 5. Pendapatan Bulan Ini -->
                <div class="col-xl col-lg-6 col-md-6 col-12 mb-3 mb-xl-0">
                    <div class="modern-stat-card">
                        <div class="stat-card-top">
                            <span class="stat-card-label">Pendapatan Bulan Ini</span>
                            <div class="stat-icon-box stat-icon-slate">
                                <span class="material-symbols-outlined">account_balance_wallet</span>
                            </div>
                        </div>
                        <div class="stat-card-number">
                            Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}
                        </div>
                        <div class="stat-card-footer justify-content-between">
                            <span>Target 88%</span>
                            <span class="text-primary font-weight-bold">Sisa 7 Hari</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 3: Two Columns (Pemesanan Terkini & Jadwal Berangkat Segera) -->
            <div class="row mb-4">
                <!-- Left: Pemesanan Terkini (~65%) -->
                <div class="col-xl-8 col-lg-7 col-12 mb-4 mb-lg-0">
                    <div class="card h-100 mb-0">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-box stat-icon-blue mr-3" style="width: 36px; height: 36px;">
                                    <span class="material-symbols-outlined" style="font-size: 20px;">receipt_long</span>
                                </div>
                                <div>
                                    <h4 class="mb-0" style="font-size: 15px;">Pemesanan Terkini</h4>
                                    <div class="text-muted" style="font-size: 12px;">Transaksi tiket yang masuk dalam 30 menit terakhir</div>
                                </div>
                            </div>
                            <a href="{{ route('admin.booking.index') }}" class="font-weight-bold text-primary" style="font-size: 12.5px;">
                                Semua Transaksi &rarr;
                            </a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Kode Booking</th>
                                            <th>Penumpang</th>
                                            <th>Operator &amp; Rute</th>
                                            <th>Waktu</th>
                                            <th>Status</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($bookingsTerbaru->take(4) as $booking)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('admin.booking.show', $booking->id) }}" class="font-weight-bold text-primary font-monospace" style="font-size: 13px;">
                                                        #{{ $booking->kode_booking }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="font-weight-bold text-dark">{{ $booking->user->name ?? 'Guest User' }}</div>
                                                    <div class="text-muted small" style="font-size: 11px;">
                                                        Kursi {{ $booking->bookingSeats->first()?->kursi?->nomor_kursi ?? '-' }} ({{ ucfirst($booking->jadwal->bus->kelas ?? 'Eksekutif') }})
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="font-weight-bold text-dark">{{ $booking->jadwal->bus->operator->nama_operator ?? '-' }}</div>
                                                    <div class="text-muted small" style="font-size: 11px;">
                                                        {{ $booking->jadwal->rute->terminalAsal->kota ?? '-' }} &rarr; {{ $booking->jadwal->rute->terminalTujuan->kota ?? '-' }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="font-weight-bold text-dark">{{ $booking->jadwal->jam_berangkat->format('H:i') }} WIB</div>
                                                    <div class="text-muted small" style="font-size: 11px;">
                                                        {{ $booking->jadwal->rute->terminalAsal->nama_terminal ?? 'Terminal Pusat' }}
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($booking->status_pembayaran == 'paid')
                                                        <span class="badge badge-success">Lunas</span>
                                                    @elseif ($booking->status_pembayaran == 'pending')
                                                        <span class="badge badge-warning">Pending</span>
                                                    @else
                                                        <span class="badge badge-danger">Batal</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.booking.show', $booking->id) }}" class="btn btn-sm btn-secondary p-1" title="Lihat Detail" style="border-radius: 8px; width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                                        <span class="material-symbols-outlined" style="font-size: 18px; color: #475569;">visibility</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4 text-muted">Belum ada pemesanan terkini</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top d-flex align-items-center justify-content-between py-3 px-4" style="border-radius: 0 0 16px 16px;">
                            <span class="text-muted small">Menampilkan {{ min(4, $bookingsTerbaru->count()) }} dari {{ number_format($totalBooking) }} pemesanan</span>
                            <div class="d-flex gap-1">
                                <button type="button" class="btn btn-sm btn-secondary" disabled style="padding: 4px 10px; font-size: 12px;">Sebelumnya</button>
                                <button type="button" class="btn btn-sm btn-primary" style="padding: 4px 10px; font-size: 12px;">1</button>
                                <button type="button" class="btn btn-sm btn-secondary" style="padding: 4px 10px; font-size: 12px;">2</button>
                                <button type="button" class="btn btn-sm btn-secondary" style="padding: 4px 10px; font-size: 12px;">Berikutnya</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Jadwal Berangkat Segera (~35%) -->
                <div class="col-xl-4 col-lg-5 col-12">
                    <div class="card h-100 mb-0">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-box stat-icon-blue mr-2" style="width: 32px; height: 32px;">
                                    <span class="material-symbols-outlined" style="font-size: 18px;">near_me</span>
                                </div>
                                <div>
                                    <h4 class="mb-0" style="font-size: 14px;">Jadwal Berangkat Segera</h4>
                                    <div class="text-muted" style="font-size: 11px;">Armada dalam persiapan keberangkatan</div>
                                </div>
                            </div>
                            <span class="stat-badge stat-badge-blue d-flex align-items-center gap-1">
                                <span class="d-inline-block rounded-circle bg-primary" style="width: 6px; height: 6px;"></span>
                                Live Dispatch
                            </span>
                        </div>
                        <div class="card-body p-3 d-flex flex-column justify-content-between">
                            
                            <!-- Bus List Items -->
                            <div class="d-flex flex-column gap-3">
                                
                                <!-- Card 1: Sinar Jaya -->
                                <div class="p-3 rounded-xl border" style="border-color: #e2e8f0; border-radius: 12px; background: #ffffff;">
                                    <div class="d-flex align-items-start justify-content-between mb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="d-flex align-items-center justify-content-center text-white font-weight-bold mr-2" style="width: 36px; height: 36px; border-radius: 10px; background: #2563eb; font-size: 13px;">
                                                SJ
                                            </div>
                                            <div>
                                                <div class="font-weight-bold text-dark" style="font-size: 13px;">Sinar Jaya (SJ-304)</div>
                                                <div class="text-muted small" style="font-size: 11px;">B 7812 SGA</div>
                                            </div>
                                        </div>
                                        <span class="stat-badge stat-badge-success d-flex align-items-center gap-1">
                                            <span class="material-symbols-outlined" style="font-size: 14px;">timer</span>
                                            18 Menit
                                        </span>
                                    </div>
                                    <div class="text-muted small mb-2" style="font-size: 12px;">
                                        Jakarta (Pulogebang) &rarr; Yogyakarta (Giwangan)
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between small text-muted mb-1" style="font-size: 11px;">
                                        <span>Keterisian Kursi: <strong class="text-dark">38 / 40</strong></span>
                                        <span class="text-success font-weight-bold">Hampir Penuh</span>
                                    </div>
                                    <div class="progress" style="height: 5px; border-radius: 4px; background-color: #f1f5f9;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 95%;"></div>
                                    </div>
                                </div>

                                <!-- Card 2: Rosalia Indah -->
                                <div class="p-3 rounded-xl border mt-2" style="border-color: #e2e8f0; border-radius: 12px; background: #ffffff;">
                                    <div class="d-flex align-items-start justify-content-between mb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="d-flex align-items-center justify-content-center text-white font-weight-bold mr-2" style="width: 36px; height: 36px; border-radius: 10px; background: #dc2626; font-size: 13px;">
                                                RI
                                            </div>
                                            <div>
                                                <div class="font-weight-bold text-dark" style="font-size: 13px;">Rosalia Indah (RI-119)</div>
                                                <div class="text-muted small" style="font-size: 11px;">AD 1482 EF</div>
                                            </div>
                                        </div>
                                        <span class="stat-badge stat-badge-warning d-flex align-items-center gap-1">
                                            <span class="material-symbols-outlined" style="font-size: 14px;">timer</span>
                                            35 Menit
                                        </span>
                                    </div>
                                    <div class="text-muted small mb-2" style="font-size: 12px;">
                                        Jakarta (Kp. Rambutan) &rarr; Surabaya (Purabaya)
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between small text-muted mb-1" style="font-size: 11px;">
                                        <span>Keterisian Kursi: <strong class="text-dark">32 / 36</strong></span>
                                        <span class="text-primary font-weight-bold">Boarding</span>
                                    </div>
                                    <div class="progress" style="height: 5px; border-radius: 4px; background-color: #f1f5f9;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 88%;"></div>
                                    </div>
                                </div>

                                <!-- Card 3: Harapan Jaya -->
                                <div class="p-3 rounded-xl border mt-2" style="border-color: #e2e8f0; border-radius: 12px; background: #ffffff;">
                                    <div class="d-flex align-items-start justify-content-between mb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="d-flex align-items-center justify-content-center text-white font-weight-bold mr-2" style="width: 36px; height: 36px; border-radius: 10px; background: #ea580c; font-size: 13px;">
                                                HJ
                                            </div>
                                            <div>
                                                <div class="font-weight-bold text-dark" style="font-size: 13px;">Harapan Jaya (HJ-88)</div>
                                                <div class="text-muted small" style="font-size: 11px;">AG 7291 UR</div>
                                            </div>
                                        </div>
                                        <span class="stat-badge stat-badge-blue d-flex align-items-center gap-1">
                                            <span class="material-symbols-outlined" style="font-size: 14px;">timer</span>
                                            50 Menit
                                        </span>
                                    </div>
                                    <div class="text-muted small mb-2" style="font-size: 12px;">
                                        Bandung (Cicaheum) &rarr; Solo (Tirtonadi)
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between small text-muted mb-1" style="font-size: 11px;">
                                        <span>Keterisian Kursi: <strong class="text-dark">24 / 32</strong></span>
                                        <span class="text-warning font-weight-bold">Check-in Buka</span>
                                    </div>
                                    <div class="progress" style="height: 5px; border-radius: 4px; background-color: #f1f5f9;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 75%;"></div>
                                    </div>
                                </div>

                            </div>

                            <!-- Footer Dispatch link -->
                            <div class="d-flex align-items-center justify-content-between pt-3 mt-3 border-top" style="border-top-color: #f1f5f9;">
                                <span class="text-muted small" style="font-size: 11px;">Terminal Pusat: Pulogebang Terpadu</span>
                                <a href="{{ route('admin.jadwal.index') }}" class="font-weight-bold text-primary small d-flex align-items-center gap-1" style="font-size: 12px;">
                                    <span>Buka Kontrol Dispatch</span>
                                    <span class="material-symbols-outlined" style="font-size: 14px;">open_in_new</span>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 4: Grafik & Analitik Tambahan (Preserved) -->
            <div class="row">
                <div class="col-lg-8 col-md-12 mb-4">
                    <div class="card h-100 mb-0">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h4 class="mb-0">Pendapatan per Bulan ({{ now()->year }})</h4>
                            <span class="badge badge-primary">Tahunan</span>
                        </div>
                        <div class="card-body">
                            <canvas id="chartPendapatan" style="height: 250px; max-height: 250px;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 mb-4">
                    <div class="card h-100 mb-0">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h4 class="mb-0">Booking per Bulan ({{ now()->year }})</h4>
                            <span class="badge badge-primary">Volume</span>
                        </div>
                        <div class="card-body">
                            <canvas id="chartBooking" style="height: 250px; max-height: 250px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Rute Terpopuler -->
                <div class="col-lg-6 col-md-12 mb-4">
                    <div class="card h-100 mb-0">
                        <div class="card-header">
                            <h4 class="mb-0">Rute Terpopuler</h4>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @forelse ($ruteTerpopuler as $rute)
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3" style="border-color: #f1f5f9;">
                                        <span class="d-flex align-items-center font-weight-bold text-dark">
                                            <span class="material-symbols-outlined mr-2 text-primary" style="font-size: 18px;">alt_route</span>
                                            {{ $rute->rute }}
                                        </span>
                                        <span class="badge badge-primary">{{ $rute->total }} booking</span>
                                    </li>
                                @empty
                                    <li class="list-group-item text-center text-muted py-4">Belum ada data</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Operator Terlaris -->
                <div class="col-lg-6 col-md-12 mb-4">
                    <div class="card h-100 mb-0">
                        <div class="card-header">
                            <h4 class="mb-0">Operator Terlaris</h4>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @forelse ($operatorTerbanyak as $op)
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3" style="border-color: #f1f5f9;">
                                        <span class="d-flex align-items-center font-weight-bold text-dark">
                                            <span class="material-symbols-outlined mr-2 text-primary" style="font-size: 18px;">domain</span>
                                            {{ $op->nama_operator }}
                                        </span>
                                        <span class="badge badge-primary">{{ $op->total }} booking</span>
                                    </li>
                                @empty
                                    <li class="list-group-item text-center text-muted py-4">Belum ada data</li>
                                @endforelse
                            </ul>
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
    var chartLabels = @json($chartLabels);
    var chartPendapatan = @json($chartPendapatan);
    var chartBooking = @json($chartBooking);

    var ctxP = document.getElementById('chartPendapatan').getContext('2d');
    new Chart(ctxP, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: chartPendapatan,
                backgroundColor: 'rgba(29, 78, 216, 0.08)',
                borderColor: '#1d4ed8',
                borderWidth: 2,
                pointBackgroundColor: '#1d4ed8',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: { display: false },
            scales: {
                yAxes: [{
                    gridLines: { color: '#f1f5f9' },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + (value >= 1000000 ? (value/1000000).toFixed(0) + ' Jt' : value);
                        }
                    }
                }],
                xAxes: [{
                    gridLines: { display: false }
                }]
            }
        }
    });

    var ctxB = document.getElementById('chartBooking').getContext('2d');
    new Chart(ctxB, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Booking',
                data: chartBooking,
                backgroundColor: 'rgba(29, 78, 216, 0.85)',
                borderColor: '#1d4ed8',
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: { display: false },
            scales: {
                yAxes: [{
                    gridLines: { color: '#f1f5f9' }
                }],
                xAxes: [{
                    gridLines: { display: false }
                }]
            }
        }
    });
</script>
@endpush