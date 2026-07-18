@extends('layouts.app', ['title' => 'Data Akun'])

@push('styles')
    <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
            --shadow-md: 0 4px 20px rgba(0,0,0,0.08);
            --shadow-lg: 0 10px 40px rgba(0,0,0,0.12);
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
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .section-header h1 {
            font-size: 28px;
            font-weight: 800;
            color: var(--dark);
            letter-spacing: -0.5px;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-header h1 i {
            color: var(--primary);
            font-size: 28px;
        }

        .header-subtitle {
            font-size: 14px;
            color: var(--secondary);
            font-weight: 400;
            margin-top: 4px;
        }

        /* Card */
        .card {
            border: none;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            transition: all 0.3s ease;
            background: white;
        }

        .card:hover {
            box-shadow: var(--shadow-lg);
        }

        .card-body {
            padding: 28px;
        }

        .card-header-custom {
            background: white;
            border-bottom: 1px solid #F1F5F9;
            padding: 20px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .card-header-custom h4 {
            font-size: 18px;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-header-custom h4 i {
            color: var(--primary);
        }

        /* Form Styling */
        .form-card {
            border: 1px solid #F1F5F9;
            border-radius: var(--radius-md);
            background: #FAFBFC;
            transition: all 0.3s ease;
        }

        .form-card:hover {
            border-color: var(--primary-light);
            background: white;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            font-weight: 600;
            font-size: 13px;
            color: var(--dark);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .form-group label i {
            color: var(--primary);
            font-size: 14px;
        }

        .form-group .form-control {
            border: 2px solid #E2E8F0;
            border-radius: var(--radius-sm);
            padding: 10px 14px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            height: 44px;
        }

        .form-group .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .form-group .form-control.is-invalid {
            border-color: var(--danger);
        }

        .form-group .form-control.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
        }

        .form-group .invalid-feedback {
            font-size: 12px;
            color: var(--danger);
            margin-top: 4px;
        }

        .role-select {
            border: 2px solid #E2E8F0;
            border-radius: var(--radius-sm);
            height: 44px;
            font-size: 14px;
            padding: 8px 14px;
            background-color: #fff;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
        }

        .role-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        /* Button Primary */
        .btn-primary-custom {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            color: white;
            border: none;
            padding: 10px 28px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.25);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.35);
            color: white;
            text-decoration: none;
        }

        .btn-primary-custom i {
            font-size: 18px;
        }

        /* Action Buttons */
        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            border: none;
            font-size: 14px;
            text-decoration: none;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            text-decoration: none;
        }

        .action-btn.edit {
            background: #FEF3C7;
            color: #92400E;
        }

        .action-btn.edit:hover {
            background: #F59E0B;
            color: white;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }

        .action-btn.delete {
            background: #FEE2E2;
            color: #991B1B;
        }

        .action-btn.delete:hover {
            background: #EF4444;
            color: white;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .action-group {
            display: flex;
            gap: 6px;
            align-items: center;
        }

        /* Role Badge */
        .role-badge {
            padding: 4px 14px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.3px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .role-badge.admin {
            background: #D1FAE5;
            color: #065F46;
        }

        .role-badge.user {
            background: #DBEAFE;
            color: #1E40AF;
        }

        .role-badge i {
            font-size: 10px;
        }

        /* DataTable Custom */
        .dataTables_wrapper {
            padding: 0;
        }

        .dataTables_wrapper .dataTables_filter {
            float: right !important;
            margin-bottom: 12px;
            margin-left: 12px;
        }

        .dataTables_wrapper .dataTables_length {
            float: left !important;
            margin-bottom: 12px;
        }

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
            padding: 6px 14px;
            font-size: 13px;
            transition: all 0.3s ease;
            min-width: 200px;
            font-family: 'Inter', sans-serif;
            background: white;
            height: 34px;
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
            height: 34px;
            width: auto;
        }

        .dataTables_wrapper .dataTables_length select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            outline: none;
        }

        /* Table */
        .table {
            margin-bottom: 0;
            font-size: 14px;
            clear: both;
        }

        .table thead th {
            background: #F8FAFC;
            color: var(--secondary);
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 14px 16px;
            border-bottom: 2px solid #E2E8F0;
        }

        .table tbody td {
            padding: 14px 16px;
            vertical-align: middle;
            border-bottom: 1px solid #F1F5F9;
            color: var(--dark);
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background: var(--primary-light);
            transform: scale(1.002);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Row Number */
        .row-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            background: var(--primary-light);
            color: var(--primary);
            border-radius: 8px;
            font-weight: 700;
            font-size: 13px;
        }

        /* User Info */
        .user-name {
            font-weight: 600;
            color: var(--dark);
            display: block;
        }

        .user-meta {
            font-size: 12px;
            color: var(--secondary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .user-meta i {
            font-size: 12px;
        }

        /* DataTable Info & Pagination */
        .dataTables_info {
            padding-top: 20px !important;
            font-size: 14px;
            color: var(--secondary);
            float: left !important;
        }

        .dataTables_paginate {
            padding-top: 20px !important;
            float: right !important;
        }

        .dataTables_paginate .paginate_button {
            padding: 6px 14px !important;
            margin: 0 3px !important;
            border-radius: 8px !important;
            border: 1px solid #E2E8F0 !important;
            color: var(--secondary) !important;
            font-weight: 500 !important;
            font-size: 13px !important;
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

        /* Stats Summary */
        .stat-card {
            background: #F8FAFC;
            border-radius: var(--radius-sm);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: all 0.3s ease;
            border: 1px solid #F1F5F9;
        }

        .stat-card:hover {
            background: white;
            border-color: var(--primary);
            box-shadow: var(--shadow-sm);
            transform: translateY(-2px);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
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
            font-size: 12px;
            font-weight: 500;
            color: var(--secondary);
            margin: 0 0 2px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-info .value {
            font-size: 22px;
            font-weight: 700;
            color: var(--dark);
            line-height: 1.2;
        }

        .row.g-3 {
            --bs-gutter-y: 0.5rem;
            --bs-gutter-x: 0.5rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-content {
                padding: 15px;
            }

            .section-header {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .section-header h1 {
                font-size: 22px;
            }

            .card-body {
                padding: 20px;
            }

            .card-header-custom {
                padding: 16px 20px;
            }

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

        /* Animation */
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

        /* Tooltip */
        [data-tooltip] {
            position: relative;
            cursor: pointer;
        }

        [data-tooltip]:before {
            content: attr(data-tooltip);
            position: absolute;
            bottom: calc(100% + 8px);
            left: 50%;
            transform: translateX(-50%);
            padding: 6px 12px;
            background: var(--dark);
            color: white;
            border-radius: 6px;
            font-size: 12px;
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

        .delete-form {
            display: inline-block;
            margin: 0;
        }

        /* SweetAlert2 Custom */
        .swal2-popup {
            border-radius: var(--radius-lg) !important;
            font-family: 'Inter', sans-serif !important;
        }

        .swal2-confirm {
            background: var(--danger) !important;
            border-radius: 50px !important;
            font-weight: 600 !important;
            padding: 10px 30px !important;
        }

        .swal2-cancel {
            background: var(--secondary) !important;
            border-radius: 50px !important;
            font-weight: 600 !important;
            padding: 10px 30px !important;
        }

        /* Divider */
        .section-divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 30px 0 25px;
        }

        .section-divider::before,
        .section-divider::after {
            content: '';
            flex: 1;
            border-bottom: 2px solid #F1F5F9;
        }

        .section-divider::before {
            margin-right: 20px;
        }

        .section-divider::after {
            margin-left: 20px;
        }

        .section-divider span {
            font-size: 14px;
            font-weight: 600;
            color: var(--secondary);
            text-transform: uppercase;
            letter-spacing: 1px;
            background: white;
            padding: 0px 20px;
        }
    </style>
@endpush

@section('content')
    <div class="main-content">
        <section class="section">
            <!-- Header -->
            <div class="section-header fade-in-up">
                <div>
                    <h1>
                        <i class="bi bi-people"></i>
                        Data Akun
                    </h1>
                    <p class="header-subtitle">
                        <i class="bi bi-database me-1"></i>
                        Kelola dan atur semua akun pengguna dengan mudah
                    </p>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">

                        <div class="card fade-in-up">
                            <div class="card-body">

                                <!-- Form Tambah Akun -->
                                <div class="card-header-custom">
                                    <h4>
                                        <i class="bi bi-person-plus"></i>
                                        Tambah Akun Baru
                                    </h4>
                                    <span class="badge bg-primary text-white" style="padding: 6px 16px; border-radius: 50px; font-size: 12px;">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Lengkapi data dengan benar
                                    </span>
                                </div>

                                <form action="{{ route('akun.store') }}" method="POST">
                                    @csrf

                                    <div class="form-card p-4 mb-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        <i class="bi bi-person"></i>
                                                        Nama Lengkap
                                                    </label>
                                                    <input 
                                                        name="name"
                                                        value="{{ old('name') }}"
                                                        required
                                                        placeholder="Masukkan Nama Lengkap"
                                                        type="text"
                                                        class="form-control @error('name') is-invalid @enderror">
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        <i class="bi bi-briefcase"></i>
                                                        Jabatan
                                                    </label>
                                                    <input 
                                                        name="jabatan"
                                                        value="{{ old('jabatan') }}"
                                                        required
                                                        placeholder="Masukkan Jabatan (- jika tidak memiliki UMKM)"
                                                        type="text"
                                                        class="form-control @error('jabatan') is-invalid @enderror">
                                                    @error('jabatan')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        <i class="bi bi-person-badge"></i>
                                                        Username
                                                    </label>
                                                    <input 
                                                        name="username"
                                                        value="{{ old('username') }}"
                                                        required
                                                        placeholder="Masukkan Username untuk login"
                                                        type="text"
                                                        class="form-control @error('username') is-invalid @enderror">
                                                    @error('username')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        <i class="bi bi-shield-lock"></i>
                                                        Role / Hak Akses
                                                    </label>
                                                    <select 
                                                        name="role"
                                                        required
                                                        class="form-control role-select @error('role') is-invalid @enderror">
                                                        <option value="">-- Pilih Role Akun --</option>
                                                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Kasubsi pelayanan & verdokjal</option>
                                                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>TI & inteldaktim</option>
                                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Kepala Kantor</option>
                                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Tata Usaha</option>
                                                    </select>
                                                    @error('role')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        <i class="bi bi-key"></i>
                                                        Password
                                                    </label>
                                                    <input 
                                                        name="password"
                                                        required
                                                        placeholder="Masukkan Password (min. 6 karakter)"
                                                        type="password"
                                                        class="form-control @error('password') is-invalid @enderror">
                                                    @error('password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        <i class="bi bi-key-fill"></i>
                                                        Konfirmasi Password
                                                    </label>
                                                    <input 
                                                        name="password_confirmation"
                                                        required
                                                        placeholder="Masukkan Ulang Password"
                                                        type="password"
                                                        class="form-control @error('password_confirmation') is-invalid @enderror">
                                                    @error('password_confirmation')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <button type="submit" class="btn-primary-custom">
                                                    <i class="bi bi-plus-circle"></i>
                                                    Tambah Data Akun
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- Divider -->
                                <div class="section-divider">
                                    <span><i class="bi bi-list-ul me-2"></i>Daftar Akun Terdaftar</span>
                                </div>

                                <!-- Stats Summary -->
                                <div class="row g-3 mb-4">
                                    <div class="col-md-3 col-sm-6">
                                        <div class="stat-card">
                                            <div class="stat-icon primary">
                                                <i class="bi bi-people"></i>
                                            </div>
                                            <div class="stat-info">
                                                <h6>Total Akun</h6>
                                                <div class="value">{{ $datas->count() }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="stat-card">
                                            <div class="stat-icon success">
                                                <i class="bi bi-shield-check"></i>
                                            </div>
                                            <div class="stat-info">
                                                <h6>Admin</h6>
                                                <div class="value">{{ $datas->where('role', 'admin')->count() }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="stat-card">
                                            <div class="stat-icon warning">
                                                <i class="bi bi-person"></i>
                                            </div>
                                            <div class="stat-info">
                                                <h6>User</h6>
                                                <div class="value">{{ $datas->where('role', 'user')->count() }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="stat-card">
                                            <div class="stat-icon info">
                                                <i class="bi bi-clock-history"></i>
                                            </div>
                                            <div class="stat-info">
                                                <h6>Terakhir Update</h6>
                                                <div class="value" style="font-size: 16px;">
                                                    {{ $datas->isNotEmpty() ? $datas->sortByDesc('updated_at')->first()->updated_at->diffForHumans() : '-' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Table -->
                                <div class="table-responsive">
                                    <table class="table table-hover" id="table-temp">
                                        <thead>
                                            <tr>
                                                <th style="width: 50px;" class="text-center">#</th>
                                                <th style="min-width: 160px;">Nama</th>
                                                <th style="min-width: 140px;">Username</th>
                                                <th style="min-width: 140px;">Role</th>
                                                <th style="width: 120px;" class="text-center">Aksi</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($datas as $i => $data)
                                                <tr>
                                                    <td class="text-center">
                                                        <span class="row-number">{{ ++$i }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="user-name">{{ $data->name }}</span>
                                                        <span class="user-meta">
                                                            <i class="bi bi-briefcase"></i>
                                                            {{ $data->jabatan ?? 'Tidak ada jabatan' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span style="font-weight: 500; color: var(--secondary);">
                                                            <i class="bi bi-person-badge me-1"></i>
                                                            {{ $data->username }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if($data->role == 'admin')
                                                            <span class="role-badge admin">
                                                                <i class="bi bi-shield-check"></i>
                                                                Admin
                                                            </span>
                                                        @else
                                                            <span class="role-badge user">
                                                                <i class="bi bi-person"></i>
                                                                User
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="action-group justify-content-center">
                                                            <a href="{{ route('akun.edit', $data->id) }}" 
                                                               class="action-btn edit" 
                                                               data-tooltip="Edit Akun">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button 
                                                                type="button"
                                                                onclick="deleteData({{ $data->id }}, 'akun')"
                                                                class="action-btn delete"
                                                                data-tooltip="Hapus Akun">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
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
@endsection

@push('scripts')
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('library/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            // Cek apakah DataTable sudah ada, jika sudah hancurkan dulu
            if ($.fn.DataTable.isDataTable('#table-temp')) {
                $('#table-temp').DataTable().destroy();
            }

            // Initialize DataTable
            var table = $('#table-temp').DataTable({
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
                    searchPlaceholder: 'Cari nama atau username...',
                    lengthMenu: 'Tampilkan _MENU_',
                    info: 'Menampilkan _START_ - _END_ dari _TOTAL_ akun',
                    infoEmpty: 'Tidak ada akun',
                    zeroRecords: 'Akun tidak ditemukan',
                },
                dom: '<"top"lf>rt<"bottom"ip>',
                columnDefs: [
                    {
                        targets: [0, 4],
                        orderable: false,
                    }
                ],
                drawCallback: function() {
                    $('[data-tooltip]').each(function() {});
                }
            });

            // Custom search styling
            $('.dataTables_filter input')
                .attr('placeholder', 'Cari nama atau username...')
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

            // Flash messages
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: '{{ session("success") }}',
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

            @if($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal!',
                    text: 'Silahkan periksa kembali data yang Anda masukkan',
                    confirmButtonColor: '#4F46E5',
                    confirmButtonText: 'OK'
                });
            @endif
        });

        // Delete function with SweetAlert2
        function deleteData(id, type) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus akun ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#64748B',
                confirmButtonText: 'Ya, Hapus!',
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
                    // Show loading
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Perform delete via AJAX
                    $.ajax({
                        url: '/' + type + '/' + id,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Akun berhasil dihapus',
                                timer: 1500,
                                showConfirmButton: false,
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat menghapus akun',
                                confirmButtonColor: '#4F46E5',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        }

        // Add animation on load
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.fade-in-up');
            elements.forEach((el, index) => {
                el.style.animationDelay = (index * 0.1) + 's';
            });
        });
    </script>
@endpush