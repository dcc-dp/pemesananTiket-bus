@extends('layouts.app', ['title' => 'Dashboard BOSS'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.28.3/dist/apexcharts.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <style>
            :root {
                --primary: #4F46E5;
                --primary-light: #EEF2FF;
                --primary-dark: #4338CA;
                --secondary: #64748B;
                --success: #10B981;
                --warning: #F59E0B;
                --danger: #EF4444;
                --info: #3B82F6;
                --dark: #0F172A;
                --light: #F8FAFC;
                --gradient-primary: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
                --gradient-success: linear-gradient(135deg, #10B981 0%, #059669 100%);
                --gradient-warning: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
                --gradient-info: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
                --gradient-danger: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
                --shadow-sm: 0 1px 3px rgba(0,0,0,0.06);
                --shadow-md: 0 4px 20px rgba(0,0,0,0.08);
                --shadow-lg: 0 10px 40px rgba(0,0,0,0.12);
                --shadow-xl: 0 20px 60px rgba(0,0,0,0.15);
                --radius-lg: 20px;
                --radius-md: 16px;
                --radius-sm: 12px;
            }

            body {
                font-family: 'Inter', sans-serif;
                background: #F1F5F9;
            }

            .main-content {
                padding: 20px 30px;
            }

            /* Header Section */
            .section-header {
                padding: 0 0 30px 0;
                border-bottom: none;
                margin-bottom: 30px;
            }

            .header-title {
                font-size: 28px;
                font-weight: 800;
                color: var(--dark);
                letter-spacing: -0.5px;
                margin-bottom: 4px;
            }

            .header-subtitle {
                font-size: 14px;
                color: var(--secondary);
                font-weight: 400;
            }

            .header-badge {
                background: var(--gradient-primary);
                color: white;
                padding: 8px 20px;
                border-radius: 50px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: 0.3px;
                box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
                display: inline-flex;
                align-items: center;
                gap: 8px;
            }

            .header-badge i {
                font-size: 16px;
            }

            /* Dashboard Cards */
            .dashboard-card {
                border: none;
                border-radius: var(--radius-lg);
                background: white;
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: var(--shadow-sm);
                position: relative;
                overflow: hidden;
                height: 100%;
            }

            .dashboard-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: var(--gradient-primary);
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .dashboard-card:hover {
                transform: translateY(-6px);
                box-shadow: var(--shadow-lg);
            }

            .dashboard-card:hover::before {
                opacity: 1;
            }

            .card-body {
                padding: 24px 28px;
            }

            .card-icon-wrapper {
                width: 56px;
                height: 56px;
                border-radius: var(--radius-sm);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 24px;
                color: white;
                flex-shrink: 0;
                position: relative;
                transition: all 0.3s ease;
            }

            .dashboard-card:hover .card-icon-wrapper {
                transform: scale(1.05);
            }

            .icon-bg-primary {
                background: var(--gradient-primary);
                box-shadow: 0 8px 24px rgba(79, 70, 229, 0.25);
            }

            .icon-bg-success {
                background: var(--gradient-success);
                box-shadow: 0 8px 24px rgba(16, 185, 129, 0.25);
            }

            .icon-bg-warning {
                background: var(--gradient-warning);
                box-shadow: 0 8px 24px rgba(245, 158, 11, 0.25);
            }

            .icon-bg-info {
                background: var(--gradient-info);
                box-shadow: 0 8px 24px rgba(59, 130, 246, 0.25);
            }

            .card-value {
                font-size: 28px;
                font-weight: 800;
                color: var(--dark);
                line-height: 1.1;
                letter-spacing: -0.5px;
            }

            .card-label {
                font-size: 13px;
                color: var(--secondary);
                font-weight: 500;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .stat-footer {
                margin-top: 14px;
                padding-top: 14px;
                border-top: 1px solid #F1F5F9;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .stat-footer .text-muted {
                font-size: 12px;
                color: var(--secondary);
            }

            .growth-badge {
                padding: 4px 12px;
                border-radius: 50px;
                font-size: 12px;
                font-weight: 600;
            }

            .growth-badge.up {
                background: #D1FAE5;
                color: #065F46;
            }

            .growth-badge.down {
                background: #FEE2E2;
                color: #991B1B;
            }

            .growth-badge.neutral {
                background: #F1F5F9;
                color: var(--secondary);
            }

            /* Mini Stats */
            .mini-stat {
                background: #F8FAFC;
                padding: 8px 14px;
                border-radius: var(--radius-sm);
                border: 1px solid #F1F5F9;
                transition: all 0.2s ease;
            }

            .mini-stat:hover {
                background: var(--primary-light);
                border-color: var(--primary);
                transform: translateY(-2px);
            }

            .mini-stat .status-badge {
                display: inline-block;
                padding: 3px 12px;
                border-radius: 50px;
                font-size: 11px;
                font-weight: 600;
                letter-spacing: 0.3px;
            }

            .status-badge.bg-success {
                background: #D1FAE5;
                color: #065F46;
            }

            .status-badge.bg-warning {
                background: #FEF3C7;
                color: #92400E;
            }

            .status-badge.bg-danger {
                background: #FEE2E2;
                color: #991B1B;
            }

            /* Chart Cards */
            .chart-card .card-header {
                padding: 20px 28px 0 28px;
                border: none;
                background: transparent;
            }

            .chart-card .card-header h6 {
                font-weight: 700;
                font-size: 16px;
                color: var(--dark);
                letter-spacing: -0.3px;
            }

            .chart-card .card-body {
                padding: 20px 28px 28px 28px;
            }

            .chart-container {
                position: relative;
                height: 300px;
            }

            /* List Items */
            .list-item {
                padding: 16px 20px;
                border-radius: var(--radius-sm);
                background: #FAFBFC;
                border: 1px solid #F1F5F9;
                transition: all 0.3s ease;
                margin-bottom: 10px;
            }

            .list-item:last-child {
                margin-bottom: 0;
            }

            .list-item:hover {
                background: white;
                border-color: var(--primary);
                box-shadow: var(--shadow-md);
                transform: translateX(4px);
            }

            .document-icon {
                width: 44px;
                height: 44px;
                border-radius: var(--radius-sm);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 20px;
                color: white;
                flex-shrink: 0;
                background: var(--gradient-primary);
            }

            .list-item-title {
                font-weight: 600;
                font-size: 14px;
                color: var(--dark);
                margin-bottom: 4px;
            }

            .list-item-meta {
                font-size: 12px;
                color: var(--secondary);
                display: flex;
                align-items: center;
                gap: 12px;
                flex-wrap: wrap;
            }

            .list-item-meta i {
                font-size: 12px;
            }

            .version-badge {
                background: var(--primary-light);
                color: var(--primary);
                padding: 2px 10px;
                border-radius: 50px;
                font-size: 11px;
                font-weight: 600;
            }

            /* Table Styling */
            .table {
                margin-bottom: 0;
            }

            .table th {
                font-size: 11px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                color: var(--secondary);
                border-bottom: 2px solid #F1F5F9;
                padding: 12px 8px;
            }

            .table td {
                padding: 12px 8px;
                font-size: 13px;
                border-bottom: 1px solid #F1F5F9;
                vertical-align: middle;
            }

            .table tbody tr {
                transition: all 0.2s ease;
            }

            .table tbody tr:hover {
                background: var(--primary-light);
            }

            .table .badge-upload {
                background: #D1FAE5;
                color: #065F46;
                padding: 4px 12px;
                border-radius: 50px;
                font-weight: 600;
                font-size: 12px;
            }

            .table .badge-revision {
                background: #FEF3C7;
                color: #92400E;
                padding: 4px 12px;
                border-radius: 50px;
                font-weight: 600;
                font-size: 12px;
            }

            /* Scrollbar */
            .recent-list::-webkit-scrollbar {
                width: 4px;
            }

            .recent-list::-webkit-scrollbar-track {
                background: #F1F5F9;
                border-radius: 10px;
            }

            .recent-list::-webkit-scrollbar-thumb {
                background: #CBD5E1;
                border-radius: 10px;
            }

            .recent-list::-webkit-scrollbar-thumb:hover {
                background: #94A3B8;
            }

            /* Responsive */
            @media (max-width: 768px) {
                .main-content {
                    padding: 15px;
                }

                .header-title {
                    font-size: 22px;
                }

                .card-body {
                    padding: 20px;
                }

                .card-value {
                    font-size: 22px;
                }

                .section-header {
                    flex-direction: column;
                    align-items: flex-start !important;
                    gap: 12px;
                }
            }

            /* Animations */
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .fade-in-up {
                animation: fadeInUp 0.6s ease forwards;
            }

            .fade-in-up:nth-child(1) { animation-delay: 0.05s; }
            .fade-in-up:nth-child(2) { animation-delay: 0.1s; }
            .fade-in-up:nth-child(3) { animation-delay: 0.15s; }
            .fade-in-up:nth-child(4) { animation-delay: 0.2s; }

            /* Glow Effect */
            .glow-primary {
                box-shadow: 0 0 40px rgba(79, 70, 229, 0.15);
            }

            /* Select styling */
            .form-control-sm {
                border-radius: var(--radius-sm);
                border: 1px solid #E2E8F0;
                padding: 6px 14px;
                font-size: 13px;
                font-weight: 500;
                color: var(--dark);
                background: white;
                transition: all 0.2s ease;
            }

            .form-control-sm:focus {
                border-color: var(--primary);
                box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            }

            /* Button */
            .btn-primary-custom {
                background: var(--gradient-primary);
                color: white;
                border: none;
                padding: 8px 20px;
                border-radius: 50px;
                font-weight: 600;
                font-size: 13px;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(79, 70, 229, 0.2);
            }

            .btn-primary-custom:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);
                color: white;
            }
        </style>
    @endpush

    <div class="main-content">
        <section class="section">
            <!-- Header -->
            <div class="section-header">
                <div class="d-flex justify-content-between align-items-center w-100 flex-wrap gap-3">
                    <div>
                        <h1 class="header-title">Dashboard BOSS</h1>
                        <p class="header-subtitle">
                            <i class="bi bi-clock me-1"></i>
                            Sistem Bantaeng Office Smart Service — Pusat Data dan Dokumen Administrasi
                        </p>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="header-badge">
                            <i class="bi bi-calendar3"></i>
                            {{ \Carbon\Carbon::now()->format('d F Y') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row g-4 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="dashboard-card fade-in-up">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <div class="card-label">Total Dokumen</div>
                                    <div class="card-value">{{ number_format($totalDokumen) }}</div>
                                    <div class="stat-footer">
                                        <span class="text-muted">
                                            <i class="bi bi-arrow-up-circle-fill text-success me-1"></i>
                                            {{ $dokumenBaru }} baru bulan ini
                                        </span>
                                        @if($growthPercentage > 0)
                                            <span class="growth-badge up">+{{ $growthPercentage }}%</span>
                                        @elseif($growthPercentage < 0)
                                            <span class="growth-badge down">{{ $growthPercentage }}%</span>
                                        @else
                                            <span class="growth-badge neutral">0%</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-icon-wrapper icon-bg-primary">
                                    <i class="bi bi-file-earmark-text"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="dashboard-card fade-in-up">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <div class="card-label">Total Kategori</div>
                                    <div class="card-value">{{ number_format($totalKategori) }}</div>
                                    <div class="stat-footer">
                                        <span class="text-muted">
                                            <i class="bi bi-grid-fill me-1"></i>
                                            Terorganisir dengan baik
                                        </span>
                                    </div>
                                </div>
                                <div class="card-icon-wrapper icon-bg-success">
                                    <i class="bi bi-folder2-open"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="dashboard-card fade-in-up">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <div class="card-label">Total Pengguna</div>
                                    <div class="card-value">{{ number_format($totalUsers) }}</div>
                                    <div class="stat-footer">
                                        <span class="text-muted">
                                            <i class="bi bi-person-plus-fill me-1"></i>
                                            Terdaftar aktif
                                        </span>
                                    </div>
                                </div>
                                <div class="card-icon-wrapper icon-bg-warning">
                                    <i class="bi bi-people"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="dashboard-card fade-in-up">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <div class="card-label">Versi Dokumen</div>
                                    <div class="card-value">{{ number_format($totalVersi) }}</div>
                                    <div class="stat-footer">
                                        <span class="text-muted">
                                            <i class="bi bi-arrow-repeat me-1"></i>
                                            {{ $dokumenRevisi }} revisi, {{ $dokumenDenganFile }} dengan file
                                        </span>
                                    </div>
                                </div>
                                <div class="card-icon-wrapper icon-bg-info">
                                    <i class="bi bi-arrow-repeat"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Summary -->
            <div class="row g-4 mb-4">
                <div class="col-lg-6">
                    <div class="dashboard-card fade-in-up">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="card-label mb-3">Status Dokumen</p>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <div class="mini-stat">
                                            <span class="status-badge bg-success">✓ Approved</span>
                                            <span class="fw-bold ms-2">{{ $dokumenAktif }}</span>
                                        </div>
                                        <div class="mini-stat">
                                            <span class="status-badge bg-warning">⟳ Review</span>
                                            <span class="fw-bold ms-2">{{ $dokumenPending }}</span>
                                        </div>
                                        <div class="mini-stat">
                                            <span class="status-badge bg-danger">✎ Draft</span>
                                            <span class="fw-bold ms-2">{{ $dokumenArsip }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-icon-wrapper icon-bg-primary" style="width: 48px; height: 48px; font-size: 20px;">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="dashboard-card fade-in-up">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="card-label mb-3">Aktivitas Terbaru</p>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <div class="mini-stat">
                                            <i class="bi bi-upload text-success me-1"></i>
                                            <span class="fw-bold">{{ $uploadBulanIni }}</span>
                                            <span class="text-muted" style="font-size: 11px;">upload bulan ini</span>
                                        </div>
                                        <div class="mini-stat">
                                            <i class="bi bi-calendar-week text-primary me-1"></i>
                                            <span class="fw-bold">{{ $uploadMingguIni }}</span>
                                            <span class="text-muted" style="font-size: 11px;">minggu ini</span>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <span class="text-muted" style="font-size: 12px;">
                                            <i class="bi bi-clock-history me-1"></i>
                                            Update terakhir: {{ \Carbon\Carbon::now()->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                                <div class="card-icon-wrapper icon-bg-info" style="width: 48px; height: 48px; font-size: 20px;">
                                    <i class="bi bi-clock-history"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row g-4 mb-4">
                <div class="col-lg-6">
                    <div class="dashboard-card chart-card fade-in-up">
                        <div class="card-header d-flex flex-row align-items-center justify-content-between">
                            <h6><i class="bi bi-graph-up-arrow text-primary me-2" style="padding: 5px;"></i>Tren Upload Dokumen</h6>
                            <select id="yearSelect" class="form-control form-control-sm" style="width: auto;">
                                @foreach(range(date('Y') - 2, date('Y')) as $year)
                                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <div id="documentTrendChart"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="dashboard-card chart-card fade-in-up">
                        <div class="card-header">
                            <h6><i class="bi bi-person-circle text-warning me-2" style="padding: 5px;"></i>Top 5 Pengguna Aktif</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-container" style="height: 250px;">
                                <div id="topUsersChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Documents & Monthly Stats -->
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="dashboard-card chart-card fade-in-up">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6><i class="bi bi-file-earmark-text text-primary me-2" style="padding: 5px;"></i>Dokumen Terbaru</h6>
                            <a href="{{ route('umkm.index') }}" class="btn btn-primary-custom btn-sm">
                                <i class="bi bi-arrow-right me-1"></i> Lihat Semua
                            </a>
                        </div>
                        <div class="card-body recent-list" style="max-height: 400px; overflow-y: auto;">
                            @forelse($recentDocuments as $dokumen)
                                <div class="list-item">
                                    <div class="d-flex align-items-start">
                                        <div class="document-icon me-3">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </div>
                                        <div class="flex-grow-1 min-w-0">
                                            <div class="list-item-title">{{ Str::limit($dokumen->judul, 50) }}</div>
                                            <div class="list-item-meta">
                                                <span><i class="bi bi-tag"></i> {{ $dokumen->kategori->nama ?? 'Tanpa Kategori' }}</span>
                                                <span><i class="bi bi-person"></i> {{ $dokumen->user->name ?? 'Unknown' }}</span>
                                                <span><i class="bi bi-clock"></i> {{ Carbon\Carbon::parse($dokumen->created_at)->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        <div class="text-end ms-2 flex-shrink-0">
                                            <span class="status-badge 
                                                @if($dokumen->status == 'aktif') bg-success
                                                @elseif($dokumen->status == 'pending') bg-warning
                                                @else bg-danger @endif">
                                                {{ ucfirst($dokumen->status) }}
                                            </span>
                                            @if($dokumen->versi > 1)
                                                <div class="mt-1">
                                                    <span class="version-badge">v{{ $dokumen->versi }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <i class="bi bi-inbox text-muted" style="font-size: 48px;"></i>
                                    <p class="text-muted mt-3">Belum ada data dokumen</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="dashboard-card chart-card fade-in-up">
                        <div class="card-header">
                            <h6><i class="bi bi-bar-chart-fill text-success me-2" style="padding: 5px;"></i>Statistik Dokumen 6 Bulan Terakhir</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Bulan</th>
                                            <th class="text-center">Upload</th>
                                            <th class="text-center">Revisi</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($monthlyStats as $stat)
                                            <tr>
                                                <td><strong>{{ $stat['month'] }}</strong></td>
                                                <td class="text-center">
                                                    <span class="badge-upload">{{ $stat['uploads'] }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge-revision">{{ $stat['revisions'] }}</span>
                                                </td>
                                                <td class="text-end fw-bold">{{ $stat['total'] }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">
                                                    <i class="bi bi-database-slash me-2"></i>Belum ada data
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.28.3/dist/apexcharts.min.js"></script>
        <script>
            // Color palette
            const colors = {
                primary: '#4F46E5',
                primaryLight: '#818CF8',
                success: '#10B981',
                warning: '#F59E0B',
                danger: '#EF4444',
                info: '#3B82F6',
                purple: '#8B5CF6'
            };

            // Document Trend Chart
            var trendChart = new ApexCharts(document.querySelector("#documentTrendChart"), {
                series: [{
                    name: 'Upload Dokumen',
                    data: @json($monthlyUploads)
                }],
                chart: {
                    type: 'area',
                    height: '100%',
                    toolbar: { show: false },
                    fontFamily: 'Inter, sans-serif',
                },
                colors: [colors.primary],
                fill: {
                    gradient: {
                        enabled: true,
                        opacityFrom: 0.7,
                        opacityTo: 0.1
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                markers: {
                    size: 5,
                    colors: ['#fff'],
                    strokeColors: colors.primary,
                    strokeWidth: 2,
                    hover: {
                        size: 7
                    }
                },
                dataLabels: { enabled: false },
                grid: {
                    borderColor: '#F1F5F9',
                    strokeDashArray: 4,
                },
                xaxis: {
                    categories: @json($monthLabels),
                    labels: {
                        style: {
                            fontSize: '11px',
                            fontWeight: 500,
                            colors: '#94A3B8'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            fontSize: '11px',
                            fontWeight: 500,
                            colors: '#94A3B8'
                        }
                    },
                    min: 0
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + " dokumen"
                        }
                    },
                    theme: 'light',
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Inter, sans-serif'
                    }
                }
            });
            trendChart.render();

            // Top Users Chart
            var topUsersData = @json($topUsersData);
            var topUsersLabels = @json($topUsersLabels);
            
            var topUsersChart = new ApexCharts(document.querySelector("#topUsersChart"), {
                series: [{
                    name: 'Jumlah Dokumen',
                    data: topUsersData.length > 0 ? topUsersData : [0]
                }],
                chart: {
                    type: 'bar',
                    height: 250,
                    toolbar: { show: false },
                    fontFamily: 'Inter, sans-serif',
                },
                colors: [colors.primary],
                plotOptions: {
                    bar: {
                        borderRadius: 6,
                        horizontal: true,
                        barHeight: '45%',
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return val + " dokumen"
                    },
                    style: {
                        fontSize: '11px',
                        fontWeight: 600,
                        colors: [colors.dark]
                    }
                },
                grid: {
                    borderColor: '#F1F5F9',
                    strokeDashArray: 4,
                },
                xaxis: {
                    categories: topUsersLabels.length > 0 ? topUsersLabels : ['Belum Ada Data'],
                    labels: {
                        style: {
                            fontSize: '11px',
                            fontWeight: 500,
                            colors: '#94A3B8'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            fontSize: '12px',
                            fontWeight: 600,
                            colors: '#475569'
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + " dokumen"
                        }
                    },
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Inter, sans-serif'
                    }
                }
            });
            topUsersChart.render();

            // Year filter
            $('#yearSelect').change(function() {
                const year = $(this).val();
                window.location.href = "{{ route('dashboard') }}?year=" + year;
            });

            // Refresh animation on load
            document.addEventListener('DOMContentLoaded', function() {
                const cards = document.querySelectorAll('.fade-in-up');
                cards.forEach((card, index) => {
                    card.style.animationDelay = (index * 0.05) + 's';
                });
            });
        </script>
    @endpush
@endsection