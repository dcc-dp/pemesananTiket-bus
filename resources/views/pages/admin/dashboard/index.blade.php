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
                        <p class="adm-subtitle">Ringkasan operasional dan performa tiket bus real-time</p>
                    </div>
                </div>

                <div class="adm-header-actions">
                    <div class="adm-date-pill">
                        <i class="far fa-calendar-alt"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                    <button type="button" onclick="window.location.reload()" class="btn-adm-refresh">
                        <i class="fas fa-sync-alt"></i>
                        <span>Refresh Data</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- 4 STATISTIK UTAMA (Compact & Clean) -->
        <div class="mb-4">
            <div class="adm-section-header">
                <h2 class="adm-section-title">Statistik Utama</h2>
                <span class="adm-section-badge">Update: Real-time</span>
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
        <div class="adm-status-strip">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="adm-status-title">
                    <i class="fas fa-chart-pie text-primary"></i>
                    Status Tiket:
                </span>
                <span class="adm-status-pill adm-pill-lunas">
                    <i class="fas fa-check-circle"></i>
                    Lunas: <strong>{{ number_format($bookingBerhasil, 0, ',', '.') }}</strong> ({{ $persenLunas }}%)
                </span>
                <span class="adm-status-pill adm-pill-pending">
                    <i class="fas fa-hourglass-half"></i>
                    Menunggu Pembayaran: <strong>{{ number_format($bookingPending, 0, ',', '.') }}</strong>
                </span>
                <span class="adm-status-pill adm-pill-batal">
                    <i class="fas fa-times-circle"></i>
                    Dibatalkan: <strong>{{ number_format($totalDibatalkan, 0, ',', '.') }}</strong>
                </span>
            </div>

            <div class="d-none d-lg-flex align-items-center gap-2 text-muted" style="font-size: 11px;">
                <span><i class="fas fa-building text-primary mr-1"></i> {{ $totalOperator }} Operator</span>
                <span>&middot;</span>
                <span><i class="fas fa-bus text-primary mr-1"></i> {{ $totalBus }} Bus</span>
                <span>&middot;</span>
                <span><i class="fas fa-map-marker-alt text-primary mr-1"></i> {{ $totalTerminal }} Terminal</span>
                <span>&middot;</span>
                <span><i class="fas fa-route text-primary mr-1"></i> {{ $totalRute }} Rute</span>
            </div>
        </div>

        <!-- GRAFIK PENJUALAN (Clean & Compact) -->
        <div class="adm-card mb-3">
            <div class="adm-card-header">
                <div class="adm-card-title-group">
                    <div class="adm-card-icon-box">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div>
                        <h3 class="adm-card-title">Grafik Performa Penjualan</h3>
                        <p class="adm-card-sub">Tren tiket terjual dan total pendapatan sistem</p>
                    </div>
                </div>

                <!-- Filter Periode (Harian, Mingguan, Bulanan) -->
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-outline-primary btn-sm py-1 px-2.5" id="btnHarian" onclick="switchPeriod('harian')" style="font-size: 11px;">Harian</button>
                    <button type="button" class="btn btn-outline-primary btn-sm py-1 px-2.5" id="btnMingguan" onclick="switchPeriod('mingguan')" style="font-size: 11px;">Mingguan</button>
                    <button type="button" class="btn btn-primary btn-sm py-1 px-2.5" id="btnBulanan" onclick="switchPeriod('bulanan')" style="font-size: 11px;">Bulanan</button>
                </div>
            </div>
            <div class="adm-card-body p-3">
                <div style="height: 220px; position: relative;">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- DUA KOLOM: PESANAN TERBARU & JADWAL BUS HARI INI -->
        <div class="row">
            <!-- KOLOM KIRI: PESANAN TERBARU (Maksimal 5 Data) -->
            <div class="col-lg-7 col-xl-8 col-12 mb-3">
                <div class="adm-card h-100 mb-0">
                    <div class="adm-card-header">
                        <div class="adm-card-title-group">
                            <div class="adm-card-icon-box">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <div>
                                <h3 class="adm-card-title">Pesanan Terbaru</h3>
                                <p class="adm-card-sub">Transaksi tiket yang masuk ke sistem</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.booking.index') }}" class="text-primary font-weight-bold" style="font-size: 11px; text-decoration: none;">
                            Semua Transaksi &rarr;
                        </a>
                    </div>

                    <div class="adm-table-wrapper">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th>Kode Booking</th>
                                    <th>Nama Penumpang</th>
                                    <th>Rute</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bookingsTerbaru->take(5) as $booking)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.booking.show', $booking->id) }}" class="booking-code-link">
                                                #{{ $booking->kode_booking }}
                                            </a>
                                        </td>
                                        <td>
                                            <div class="font-weight-bold text-dark">{{ $booking->user->name ?? 'Penumpang' }}</div>
                                            <div class="text-muted" style="font-size: 10.5px;">
                                                @if($booking->bookingSeats->count() > 0)
                                                    Kursi: {{ $booking->bookingSeats->map(fn($s) => $s->kursi->nomor_kursi ?? '')->filter()->join(', ') }}
                                                @else
                                                    Kursi Standar
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="font-weight-600 text-dark">
                                                {{ $booking->jadwal->rute->terminalAsal->kota ?? 'Asal' }} &rarr; {{ $booking->jadwal->rute->terminalTujuan->kota ?? 'Tujuan' }}
                                            </div>
                                            <div class="text-muted" style="font-size: 10.5px;">
                                                {{ $booking->jadwal->bus->nama_bus ?? 'Armada Bus' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-dark">{{ $booking->tanggal_booking ? $booking->tanggal_booking->format('d M Y') : '-' }}</div>
                                            <div class="text-muted" style="font-size: 10.5px;">
                                                {{ $booking->tanggal_booking ? $booking->tanggal_booking->format('H:i') : '' }} WIB
                                            </div>
                                        </td>
                                        <td>
                                            @if ($booking->status_pembayaran == 'paid')
                                                <span class="adm-status-pill adm-pill-lunas">Lunas</span>
                                            @elseif ($booking->status_pembayaran == 'pending')
                                                <span class="adm-status-pill adm-pill-pending">Menunggu Pembayaran</span>
                                            @else
                                                <span class="adm-status-pill adm-pill-batal">Dibatalkan</span>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.booking.show', $booking->id) }}" class="btn btn-sm btn-outline-primary" style="border-radius: 6px; padding: 2px 7px; font-size: 11px;" title="Lihat Detail">
                                                <i class="far fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            <i class="far fa-folder-open mb-1 d-block" style="font-size: 20px;"></i>
                                            Belum ada pesanan terbaru.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="p-2.5 px-3 border-top d-flex align-items-center justify-content-between text-muted" style="font-size: 11px; background: #fafbfc;">
                        <span>Menampilkan {{ min(5, $bookingsTerbaru->count()) }} dari {{ $totalBooking }} pesanan</span>
                        <a href="{{ route('admin.booking.index') }}" class="font-weight-bold text-primary" style="font-size: 11px;">Lihat Tabel Lengkap &rarr;</a>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: JADWAL BUS HARI INI (Live Dispatch Sesuai Referensi Gambar) -->
            <div class="col-lg-5 col-xl-4 col-12 mb-3">
                <div class="adm-card h-100 mb-0">
                    <div class="adm-card-header">
                        <div class="adm-card-title-group">
                            <div class="adm-card-icon-box" style="background: #ecfeff; color: #0891b2;">
                                <i class="fas fa-bus"></i>
                            </div>
                            <div>
                                <h3 class="adm-card-title">Jadwal Bus Hari Ini</h3>
                                <p class="adm-card-sub">Armada dalam persiapan keberangkatan</p>
                            </div>
                        </div>
                        <span class="badge badge-pill badge-primary-light" style="font-size: 9.5px; font-weight: 700; background: #eff6ff; color: #1d4ed8; padding: 3px 8px;">
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

                                <div class="dispatch-item">
                                    <div class="dispatch-header">
                                        <div class="dispatch-bus-info">
                                            <div class="dispatch-badge-initial" style="background: {{ $bgInisial }};">
                                                {{ $inisial }}
                                            </div>
                                            <div>
                                                <span class="dispatch-bus-name">{{ $jadwal->bus->nama_bus }}</span>
                                                <span class="dispatch-plate">{{ $jadwal->bus->nomor_polisi ?? 'BUS-' . $jadwal->id_bus }}</span>
                                            </div>
                                        </div>
                                        <div class="dispatch-countdown {{ $idx == 1 ? 'warning' : '' }}">
                                            <i class="far fa-clock"></i>
                                            <span>{{ $jadwal->jam_berangkat->format('H:i') }}</span>
                                        </div>
                                    </div>

                                    <!-- Rute -->
                                    <div class="dispatch-route">
                                        <span>{{ $jadwal->rute->terminalAsal->kota ?? 'Asal' }}</span>
                                        <i class="fas fa-arrow-right text-muted" style="font-size: 9px;"></i>
                                        <span>{{ $jadwal->rute->terminalTujuan->kota ?? 'Tujuan' }}</span>
                                    </div>

                                    <!-- Progress Keterisian Kursi -->
                                    <div class="dispatch-occupancy">
                                        <span class="text-muted" style="font-size: 10.5px;">Kursi: <strong>{{ $terisi }}/{{ $kapasitas }}</strong></span>
                                        <div class="dispatch-progress">
                                            <div class="dispatch-progress-bar" style="width: {{ max(15, $persenKursi) }}%; background: {{ $persenKursi > 80 ? '#10b981' : ($persenKursi > 40 ? '#1d4ed8' : '#f59e0b') }};"></div>
                                        </div>
                                        <span style="font-size: 10px; font-weight: 700; color: {{ $persenKursi > 80 ? '#059669' : '#1d4ed8' }};">
                                            {{ $persenKursi > 85 ? 'Penuh' : ($persenKursi > 0 ? 'Boarding' : 'Tersedia') }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-3 text-muted" style="font-size: 11.5px;">
                                    <i class="fas fa-calendar-times mb-1 d-block" style="font-size: 20px;"></i>
                                    Tidak ada jadwal aktif untuk hari ini.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="p-2.5 px-3 border-top d-flex align-items-center justify-content-between text-muted" style="font-size: 11px; background: #fafbfc;">
                        <span>Dispatch Terpadu</span>
                        <a href="{{ route('admin.jadwal.index') }}" class="font-weight-bold text-primary" style="font-size: 11px;">
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