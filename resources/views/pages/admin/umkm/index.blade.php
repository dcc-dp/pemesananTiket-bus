@extends('layouts.app', ['title' => 'Data Dokumen'])

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/sweetalert2/dist/sweetalert2.min.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

<style>
    :root {
        --primary: #4F46E5;
        --primary-light: #EEF2FF;
        --primary-dark: #4338CA;
        --success: #10B981;
        --warning: #F59E0B;
        --danger: #EF4444;
        --info: #3B82F6;
        --secondary: #64748B;
        --dark: #0F172A;
        --light: #F8FAFC;
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.06);
        --shadow-md: 0 4px 15px rgba(0,0,0,0.08);
        --radius-lg: 16px;
        --radius-md: 12px;
        --radius-sm: 8px;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: #F1F5F9;
    }

    .main-content {
        padding: 15px 25px;
    }

    /* Header Section - Compact */
    .section-header {
        padding: 0 0 20px 0;
        border-bottom: none;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .section-header h1 {
        font-size: 22px;
        font-weight: 700;
        color: var(--dark);
        letter-spacing: -0.3px;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-header h1 i {
        color: var(--primary);
        font-size: 22px;
    }

    .header-subtitle {
        font-size: 13px;
        color: var(--secondary);
        font-weight: 400;
        margin-top: 2px;
    }

    .header-actions {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
    }

    /* Breadcrumb - Compact */
    .section-header-breadcrumb {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
    }

    .section-header-breadcrumb .breadcrumb-item {
        color: var(--secondary);
    }

    .section-header-breadcrumb .breadcrumb-item a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .section-header-breadcrumb .breadcrumb-item a:hover {
        color: var(--primary-dark);
    }

    .section-header-breadcrumb .breadcrumb-item.active {
        color: var(--dark);
        font-weight: 600;
    }

    /* Card - Compact */
    .card {
        border: none;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        transition: all 0.3s ease;
        background: white;
    }

    .card:hover {
        box-shadow: var(--shadow-md);
    }

    .card-header {
        background: white;
        border-bottom: 1px solid #F1F5F9;
        padding: 14px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .card-header h4 {
        font-size: 15px;
        font-weight: 600;
        color: var(--dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .card-header h4 i {
        color: var(--primary);
        font-size: 16px;
    }

    .card-body {
        padding: 18px 20px 20px;
    }

    /* Button Primary - Compact */
    .btn-primary-custom {
        background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
        color: white;
        border: none;
        padding: 7px 18px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s ease;
        box-shadow: 0 3px 12px rgba(79, 70, 229, 0.2);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(79, 70, 229, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-primary-custom i {
        font-size: 16px;
    }

    /* Action Buttons - Compact */
    .action-buttons {
        display: flex;
        gap: 4px;
        align-items: center;
        justify-content: center;
    }

    .btn-action {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        border: none;
        font-size: 13px;
        text-decoration: none;
        padding: 0;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        text-decoration: none;
    }

    .btn-action.edit {
        background: #FEF3C7;
        color: #92400E;
    }

    .btn-action.edit:hover {
        background: #F59E0B;
        color: white;
        box-shadow: 0 3px 12px rgba(245, 158, 11, 0.3);
    }

    .btn-action.delete {
        background: #FEE2E2;
        color: #991B1B;
    }

    .btn-action.delete:hover {
        background: #EF4444;
        color: white;
        box-shadow: 0 3px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-action.view {
        background: #E0F2FE;
        color: #0369A1;
    }

    .btn-action.view:hover {
        background: #3B82F6;
        color: white;
        box-shadow: 0 3px 12px rgba(59, 130, 246, 0.3);
    }

    /* Badge Status - Compact */
    .badge-status {
        padding: 3px 10px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.2px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }

    .badge-status.draft {
        background: #FEF3C7;
        color: #92400E;
    }

    .badge-status.review {
        background: #DBEAFE;
        color: #1E40AF;
    }

    .badge-status.approved {
        background: #D1FAE5;
        color: #065F46;
    }

    .badge-status.obsolete {
        background: #FEE2E2;
        color: #991B1B;
    }

    .badge-status i {
        font-size: 9px;
    }

    /* Version Badge - Compact */
    .version-badge {
        background: var(--primary-light);
        color: var(--primary);
        padding: 2px 10px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 3px;
    }

    /* DataTable Custom - Compact */
    .dataTables_wrapper {
        padding: 0;
    }

    /* DataTable top section - flex layout untuk search di kanan */
    .dataTables_wrapper .dataTables_filter {
        float: right !important;
        margin-bottom: 12px;
        margin-left: 12px;
    }

    .dataTables_wrapper .dataTables_length {
        float: left !important;
        margin-bottom: 12px;
    }

    /* Clear floats */
    .dataTables_wrapper .dataTables_filter:after,
    .dataTables_wrapper .dataTables_length:after {
        content: '';
        display: table;
        clear: both;
    }

    /* DataTables top wrapper */
    .dataTables_wrapper .dataTables_filter label {
        font-weight: 500;
        color: var(--secondary);
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 0;
    }

    .dataTables_wrapper .dataTables_filter input {
        border: 2px solid #E2E8F0;
        border-radius: var(--radius-sm);
        padding: 5px 12px;
        font-size: 13px;
        transition: all 0.3s ease;
        min-width: 200px;
        font-family: 'Inter', sans-serif;
        background: white;
        height: 32px;
        margin-left: 0;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        outline: none;
    }

    .dataTables_wrapper .dataTables_length label {
        font-weight: 500;
        color: var(--secondary);
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 0;
    }

    .dataTables_wrapper .dataTables_length select {
        border: 2px solid #E2E8F0;
        border-radius: var(--radius-sm);
        padding: 4px 10px;
        font-size: 13px;
        font-family: 'Inter', sans-serif;
        background: white;
        height: 32px;
        width: auto;
    }

    .dataTables_wrapper .dataTables_length select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        outline: none;
    }

    /* Clear wrapper for top section */
    .dataTables_wrapper .dataTables_filter {
        margin-top: 0;
    }

    /* Table - Compact */
    .table {
        margin-bottom: 0;
        font-size: 13px;
        width: 100% !important;
        clear: both;
    }

    .table thead th {
        background: #F8FAFC;
        color: var(--secondary);
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        padding: 8px 12px;
        border-bottom: 2px solid #E2E8F0;
        position: sticky;
        top: 0;
        z-index: 10;
        white-space: nowrap;
    }

    .table tbody td {
        padding: 8px 12px;
        vertical-align: middle;
        border-bottom: 1px solid #F1F5F9;
        color: var(--dark);
    }

    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background: var(--primary-light);
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Row Number - Compact */
    .row-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 26px;
        height: 26px;
        background: var(--primary-light);
        color: var(--primary);
        border-radius: 6px;
        font-weight: 700;
        font-size: 12px;
    }

    /* Document Title - Compact */
    .doc-title {
        font-weight: 600;
        color: var(--dark);
        display: block;
        font-size: 13px;
        margin-bottom: 1px;
    }

    .doc-meta {
        font-size: 11px;
        color: var(--secondary);
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .doc-meta i {
        font-size: 11px;
    }

    /* Empty State - Compact */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
    }

    .empty-state i {
        font-size: 48px;
        color: #CBD5E1;
        margin-bottom: 16px;
    }

    .empty-state h5 {
        font-size: 18px;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 6px;
    }

    .empty-state p {
        color: var(--secondary);
        font-size: 13px;
    }

    /* DataTable Info & Pagination - Compact */
    .dataTables_info {
        padding-top: 12px !important;
        font-size: 13px;
        color: var(--secondary);
        float: left !important;
    }

    .dataTables_paginate {
        padding-top: 12px !important;
        float: right !important;
    }

    .dataTables_paginate .paginate_button {
        padding: 4px 12px !important;
        margin: 0 2px !important;
        border-radius: 6px !important;
        border: 1px solid #E2E8F0 !important;
        color: var(--secondary) !important;
        font-weight: 500 !important;
        font-size: 12px !important;
        transition: all 0.3s ease !important;
        background: white !important;
    }

    .dataTables_paginate .paginate_button.current {
        background: var(--primary) !important;
        color: white !important;
        border-color: var(--primary) !important;
    }

    .dataTables_paginate .paginate_button:hover {
        background: var(--primary-light) !important;
        border-color: var(--primary) !important;
        color: var(--primary) !important;
    }

    .dataTables_paginate .paginate_button.disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    /* Stats Summary - Compact */
    .stat-card {
        background: #F8FAFC;
        border-radius: var(--radius-sm);
        padding: 10px 14px;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.3s ease;
        border: 1px solid #F1F5F9;
    }

    .stat-card:hover {
        background: white;
        border-color: var(--primary);
        box-shadow: var(--shadow-sm);
        transform: translateY(-1px);
    }

    .stat-icon {
        width: 38px;
        height: 38px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .stat-icon.primary {
        background: var(--primary-light);
        color: var(--primary);
    }

    .stat-icon.success {
        background: #D1FAE5;
        color: var(--success);
    }

    .stat-icon.warning {
        background: #FEF3C7;
        color: var(--warning);
    }

    .stat-icon.info {
        background: #DBEAFE;
        color: var(--info);
    }

    .stat-info h6 {
        font-size: 10px;
        font-weight: 500;
        color: var(--secondary);
        margin: 0 0 1px 0;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .stat-info .value {
        font-size: 18px;
        font-weight: 700;
        color: var(--dark);
        line-height: 1.2;
    }

    .row.g-3 {
        --bs-gutter-y: 0.5rem;
        --bs-gutter-x: 0.5rem;
    }

    .mb-4 {
        margin-bottom: 0.75rem !important;
    }

    /* Responsive - Compact */
    @media (max-width: 768px) {
        .main-content {
            padding: 10px 15px;
        }

        .section-header {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 8px;
        }

        .section-header h1 {
            font-size: 19px;
        }

        .card-body {
            padding: 14px 16px 16px;
        }

        .card-header {
            padding: 12px 16px;
        }

        /* Mobile: search di bawah length */
        .dataTables_wrapper .dataTables_filter {
            float: none !important;
            margin-left: 0;
            width: 100%;
        }

        .dataTables_wrapper .dataTables_length {
            float: none !important;
            margin-bottom: 8px;
            width: 100%;
        }

        .dataTables_wrapper .dataTables_filter input {
            min-width: 100%;
            width: 100%;
        }

        .dataTables_wrapper .dataTables_filter label {
            width: 100%;
            flex-direction: column;
            align-items: stretch;
        }

        .dataTables_wrapper .dataTables_length label {
            width: 100%;
        }

        .dataTables_wrapper .dataTables_length select {
            width: auto;
            min-width: 60px;
        }

        .action-buttons {
            flex-wrap: wrap;
            gap: 3px;
        }

        .stat-card {
            padding: 8px 12px;
        }

        .stat-info .value {
            font-size: 16px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .dataTables_info {
            float: none !important;
            text-align: center;
        }

        .dataTables_paginate {
            float: none !important;
            text-align: center;
            margin-top: 8px;
        }
    }

    @media (max-width: 480px) {
        .section-header-breadcrumb {
            font-size: 11px;
        }
    }

    /* Animation - Compact */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(15px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in-up {
        animation: fadeInUp 0.5s ease forwards;
    }

    /* Tooltip - Compact */
    [data-tooltip] {
        position: relative;
        cursor: pointer;
    }

    [data-tooltip]:before {
        content: attr(data-tooltip);
        position: absolute;
        bottom: calc(100% + 6px);
        left: 50%;
        transform: translateX(-50%);
        padding: 4px 10px;
        background: var(--dark);
        color: white;
        border-radius: 4px;
        font-size: 11px;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: all 0.3s ease;
        font-weight: 500;
        z-index: 1000;
    }

    [data-tooltip]:hover:before {
        opacity: 1;
    }

    /* Delete form */
    .delete-form {
        display: inline-block;
        margin: 0;
    }

    /* SweetAlert2 Custom - Compact */
    .swal2-popup {
        border-radius: var(--radius-lg) !important;
        font-family: 'Inter', sans-serif !important;
        padding: 1.5rem !important;
    }

    .swal2-confirm {
        background: var(--danger) !important;
        border-radius: 50px !important;
        font-weight: 600 !important;
        padding: 8px 24px !important;
        font-size: 14px !important;
    }

    .swal2-cancel {
        background: var(--secondary) !important;
        border-radius: 50px !important;
        font-weight: 600 !important;
        padding: 8px 24px !important;
        font-size: 14px !important;
    }
</style>
@endpush

<div class="main-content">
    <section class="section">

        <!-- Header -->
        <div class="section-header fade-in-up">
            <div>
                <h1>
                    <i class="bi bi-file-earmark-text"></i>
                    Data Dokumen
                </h1>
                <p class="header-subtitle">
                    <i class="bi bi-database me-1"></i>
                    Kelola dan pantau semua dokumen administrasi
                </p>
            </div>
            <div class="header-actions">
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">
                            <i class="bi bi-house-door"></i> Dashboard
                        </a>
                    </div>
                    <div class="breadcrumb-item active">
                        <i class="bi bi-file-earmark-text"></i> Data Dokumen
                    </div>
                </div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">

                    <div class="card fade-in-up">

                        <div class="card-header">
                            <h4>
                                <i class="bi bi-list-ul"></i>
                                Daftar Dokumen
                            </h4>
                            <div class="card-header-action">
                                <a href="{{ route('umkm.create') }}" class="btn-primary-custom">
                                    <i class="bi bi-plus-circle"></i>
                                    Tambah Data
                                </a>
                            </div>
                        </div>

                        <div class="card-body">

                            <!-- Stats Summary -->
                            <div class="row g-3 mb-3">
                                <div class="col-md-3 col-sm-6">
                                    <div class="stat-card">
                                        <div class="stat-icon primary">
                                            <i class="bi bi-files"></i>
                                        </div>
                                        <div class="stat-info">
                                            <h6>Total</h6>
                                            <div class="value">{{ $datas->count() }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="stat-card">
                                        <div class="stat-icon success">
                                            <i class="bi bi-check-circle"></i>
                                        </div>
                                        <div class="stat-info">
                                            <h6>Approved</h6>
                                            <div class="value">{{ $datas->where('status', 'approved')->count() }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="stat-card">
                                        <div class="stat-icon warning">
                                            <i class="bi bi-clock-history"></i>
                                        </div>
                                        <div class="stat-info">
                                            <h6>Review & Draft</h6>
                                            <div class="value">{{ $datas->whereIn('status', ['review', 'draft'])->count() }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="stat-card">
                                        <div class="stat-icon info">
                                            <i class="bi bi-file-pdf"></i>
                                        </div>
                                        <div class="stat-info">
                                            <h6>Dengan File</h6>
                                            <div class="value">{{ $datas->whereNotNull('file_path')->count() }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="table-responsive">

                                <table class="table table-striped" id="table-dokumen">

                                    <thead>
                                        <tr>
                                            <th style="width: 40px;">#</th>
                                            <th style="min-width: 100px;">No Dokumen</th>
                                            <th style="min-width: 150px;">Judul</th>
                                            <th style="min-width: 100px;">Kategori</th>
                                            <th style="min-width: 85px;">Tanggal</th>
                                            <th style="width: 65px;">Versi</th>
                                            <th style="width: 85px;">Status</th>
                                            <th style="width: 45px;">File</th>
                                            <th style="width: 95px;">Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($datas as $index => $dokumen)
                                        <tr>
                                            <td>
                                                <span class="row-number">{{ $index + 1 }}</span>
                                            </td>
                                            <td>
                                                <span style="font-weight: 600; color: var(--dark); font-size: 12px;">
                                                    {{ $dokumen->nomor_dokumen }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="doc-title">{{ Str::limit($dokumen->judul, 40) }}</span>
                                                <span class="doc-meta">
                                                    <span>
                                                        <i class="bi bi-person"></i>
                                                        {{ $dokumen->user->name ?? 'Unknown' }}
                                                    </span>
                                                </span>
                                            </td>
                                            <td>
                                                <span style="font-weight: 500; color: var(--secondary); font-size: 12px;">
                                                    {{ $dokumen->kategori->nama ?? '-' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span style="font-size: 12px;">
                                                    {{ date('d-m-Y', strtotime($dokumen->tanggal_dokumen)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="version-badge">
                                                    <i class="bi bi-tag"></i>
                                                    v{{ $dokumen->versi }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($dokumen->status == 'draft')
                                                    <span class="badge-status draft">
                                                        <i class="bi bi-pencil"></i> Draft
                                                    </span>
                                                @elseif($dokumen->status == 'review')
                                                    <span class="badge-status review">
                                                        <i class="bi bi-eye"></i> Review
                                                    </span>
                                                @elseif($dokumen->status == 'approved')
                                                    <span class="badge-status approved">
                                                        <i class="bi bi-check-circle-fill"></i> Approved
                                                    </span>
                                                @else
                                                    <span class="badge-status obsolete">
                                                        <i class="bi bi-x-circle"></i> Obsolete
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($dokumen->file_path)
                                                    <a href="{{ asset('storage/'.$dokumen->file_path) }}"
                                                       target="_blank"
                                                       class="btn-action view"
                                                       data-tooltip="Lihat File">
                                                        <i class="bi bi-file-earmark-pdf"></i>
                                                    </a>
                                                @else
                                                    <span style="color: #CBD5E1; font-size: 12px;">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="{{ route('umkm.edit', $dokumen->id) }}"
                                                       class="btn-action edit"
                                                       data-tooltip="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('umkm.hapus', $dokumen->id) }}"
                                                          method="POST"
                                                          class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                                class="btn-action delete delete-btn"
                                                                data-tooltip="Hapus">
                                                            <i class="bi bi-trash3"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="9">
                                                <div class="empty-state">
                                                    <i class="bi bi-inbox"></i>
                                                    <h5>Belum Ada Dokumen</h5>
                                                    <p>Mulai tambahkan dokumen pertama Anda</p>
                                                    <a href="{{ route('umkm.create') }}" class="btn-primary-custom" style="display: inline-flex; margin-top: 8px;">
                                                        <i class="bi bi-plus-circle"></i>
                                                        Tambah Dokumen
                                                    </a>
                                                </div>
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

        </div>

    </section>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.18/dist/sweetalert2.all.min.js"></script>
<script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('library/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>

<script>
$(document).ready(function() {

    // Initialize DataTable
    var table = $('#table-dokumen').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.1.0/i18n/id.json',
            search: '<i class="bi bi-search me-1"></i>Cari',
            searchPlaceholder: 'Cari dokumen...',
            lengthMenu: 'Tampilkan _MENU_',
            info: 'Menampilkan _START_-_END_ dari _TOTAL_ data',
            infoEmpty: 'Tidak ada data',
            zeroRecords: 'Data tidak ditemukan',
        },
        dom: '<"top"lf>rt<"bottom"ip>',
        columnDefs: [
            {
                targets: [0, 5, 6, 7, 8],
                orderable: false,
            },
            {
                targets: 6,
                render: function(data, type, row) {
                    if (data === 'draft') {
                        return '<span class="badge-status draft"><i class="bi bi-pencil"></i> Draft</span>';
                    } else if (data === 'review') {
                        return '<span class="badge-status review"><i class="bi bi-eye"></i> Review</span>';
                    } else if (data === 'approved') {
                        return '<span class="badge-status approved"><i class="bi bi-check-circle-fill"></i> Approved</span>';
                    } else {
                        return '<span class="badge-status obsolete"><i class="bi bi-x-circle"></i> Obsolete</span>';
                    }
                }
            }
        ],
        drawCallback: function() {
            $('[data-tooltip]').each(function() {});
        }
    });

    // Custom search styling
    $('.dataTables_filter input')
        .attr('placeholder', 'Cari dokumen...')
        .addClass('form-control form-control-sm');

    $('.dataTables_length select').addClass('form-control form-control-sm');

    // Responsive adjustments
    function handleResponsive() {
        if ($(window).width() < 768) {
            $('.dataTables_filter input').css('min-width', '100%');
            $('.dataTables_filter').css('margin-left', '0');
        } else {
            $('.dataTables_filter input').css('min-width', '200px');
        }
    }

    handleResponsive();
    $(window).resize(handleResponsive);

    // Delete button with SweetAlert2
    $('.delete-btn').click(function(e) {
        e.preventDefault();

        let form = $(this).closest('form');
        let docTitle = $(this).closest('tr').find('.doc-title').text().trim();

        Swal.fire({
            title: 'Hapus Dokumen?',
            html: `
                <div style="text-align: left; padding: 6px 0;">
                    <p style="margin-bottom: 6px; color: #64748B; font-size: 14px;">
                        <i class="bi bi-file-earmark-text" style="color: #4F46E5;"></i>
                        <strong>${docTitle}</strong>
                    </p>
                    <p style="color: #EF4444; font-size: 13px; margin: 0;">
                        <i class="bi bi-exclamation-triangle"></i>
                        Data akan dihapus permanen!
                    </p>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-4',
                confirmButton: 'btn btn-danger px-4 py-2',
                cancelButton: 'btn btn-secondary px-4 py-2',
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Menghapus...',
                    text: 'Mohon tunggu',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Dokumen berhasil dihapus',
                            timer: 1200,
                            showConfirmButton: false,
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan',
                            confirmButtonColor: '#4F46E5',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    });

    // Flash messages
    @if(session('message'))
        Swal.fire({
            icon: 'success',
            title: 'Sukses!',
            text: '{{ session("message") }}',
            timer: 2500,
            showConfirmButton: true,
            confirmButtonColor: '#4F46E5',
            confirmButtonText: 'OK'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session("error") }}',
            confirmButtonColor: '#4F46E5',
            confirmButtonText: 'OK'
        });
    @endif

});

// Add animation on load
document.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelectorAll('.fade-in-up');
    elements.forEach((el, index) => {
        el.style.animationDelay = (index * 0.08) + 's';
    });
});
</script>
@endpush
@endsection