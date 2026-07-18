@extends('layouts.app', ['title' => 'Data Jenis Usaha'])

@section('content')
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
            }

            .header-subtitle {
                font-size: 14px;
                color: var(--secondary);
                font-weight: 400;
                margin-top: 4px;
            }

            .header-actions {
                display: flex;
                gap: 10px;
                align-items: center;
                flex-wrap: wrap;
            }

            /* Card */
            .card {
                border: none;
                border-radius: var(--radius-lg);
                box-shadow: var(--shadow-sm);
                overflow: hidden;
                transition: all 0.3s ease;
            }

            .card:hover {
                box-shadow: var(--shadow-lg);
            }

            .card-body {
                padding: 28px;
            }

            /* Button Primary */
            .btn-primary-custom {
                background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
                color: white;
                border: none;
                padding: 10px 24px;
                border-radius: 50px;
                font-weight: 600;
                font-size: 14px;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(79, 70, 229, 0.25);
                display: inline-flex;
                align-items: center;
                gap: 8px;
                text-decoration: none;
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

            /* DataTable Custom */
            .dataTables_wrapper {
                padding: 0;
            }

            .dataTables_wrapper .dataTables_filter {
                margin-bottom: 20px;
            }

            .dataTables_wrapper .dataTables_filter label {
                font-weight: 500;
                color: var(--secondary);
                font-size: 14px;
            }

            .dataTables_wrapper .dataTables_filter input {
                border: 2px solid #E2E8F0;
                border-radius: var(--radius-sm);
                padding: 8px 16px;
                font-size: 14px;
                transition: all 0.3s ease;
                margin-left: 10px;
                min-width: 250px;
                font-family: 'Inter', sans-serif;
            }

            .dataTables_wrapper .dataTables_filter input:focus {
                border-color: var(--primary);
                box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
                outline: none;
            }

            .dataTables_wrapper .dataTables_length select {
                border: 2px solid #E2E8F0;
                border-radius: var(--radius-sm);
                padding: 6px 12px;
                font-size: 14px;
                font-family: 'Inter', sans-serif;
            }

            .dataTables_wrapper .dataTables_length select:focus {
                border-color: var(--primary);
                box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
                outline: none;
            }

            /* Table */
            .table {
                margin-bottom: 0;
                font-size: 14px;
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
                position: sticky;
                top: 0;
                z-index: 10;
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
                transform: scale(1.005);
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

            /* Badge Status / Label */
            .badge-custom {
                padding: 4px 12px;
                border-radius: 50px;
                font-size: 12px;
                font-weight: 600;
            }

            .badge-custom.primary {
                background: var(--primary-light);
                color: var(--primary);
            }

            /* Empty State */
            .empty-state {
                text-align: center;
                padding: 60px 20px;
            }

            .empty-state i {
                font-size: 64px;
                color: #CBD5E1;
                margin-bottom: 20px;
            }

            .empty-state h5 {
                font-size: 20px;
                font-weight: 600;
                color: var(--dark);
                margin-bottom: 8px;
            }

            .empty-state p {
                color: var(--secondary);
                font-size: 14px;
            }

            /* DataTable Info & Pagination */
            .dataTables_info {
                padding-top: 20px !important;
                font-size: 14px;
                color: var(--secondary);
            }

            .dataTables_paginate {
                padding-top: 20px !important;
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

                .dataTables_wrapper .dataTables_filter input {
                    min-width: 180px;
                    width: 100%;
                }

                .action-group {
                    flex-wrap: wrap;
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

            /* Toast notification style */
            .toast-container {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
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
            }

            [data-tooltip]:hover:before {
                opacity: 1;
            }

            /* Description styling */
            .desc-text {
                max-width: 300px;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                line-height: 1.5;
                color: #475569;
            }
        </style>
    @endpush

    <div class="main-content">
        <section class="section">
            <!-- Header -->
            <div class="section-header fade-in-up">
                <div>
                    <h1>
                        <i class="bi bi-briefcase text-primary" style="font-size: 28px;"></i>
                        Data Kategori Dokumen
                    </h1>
                    <p class="header-subtitle">
                        <i class="bi bi-database me-1"></i>
                        Kelola dan atur data kategori dokumen dengan mudah
                    </p>
                </div>
                <div class="header-actions">
                    <a href="{{ route('jenis_usaha.create') }}" class="btn-primary-custom">
                        <i class="bi bi-plus-circle"></i>
                        Tambah Data
                    </a>
                </div>
            </div>

            <!-- Main Card -->
            <div class="row">
                <div class="col-12">
                    <div class="card fade-in-up">
                        <div class="card-body">
                            <!-- Stats Summary -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-4 col-sm-6">
                                    <div class="d-flex align-items-center p-3 bg-light rounded-3" style="background: #F8FAFC; border-radius: var(--radius-sm);">
                                        <div class="me-3" style="width: 44px; height: 44px; background: var(--primary-light); border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-database text-primary" style="font-size: 20px;"></i>
                                        </div>
                                        <div>
                                            <div style="font-size: 12px; color: var(--secondary); font-weight: 500;">Total Data</div>
                                            <div style="font-size: 22px; font-weight: 700; color: var(--dark);">{{ $datas->count() }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="d-flex align-items-center p-3 bg-light rounded-3" style="background: #F8FAFC; border-radius: var(--radius-sm);">
                                        <div class="me-3" style="width: 44px; height: 44px; background: #D1FAE5; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-plus-circle text-success" style="font-size: 20px;"></i>
                                        </div>
                                        <div>
                                            <div style="font-size: 12px; color: var(--secondary); font-weight: 500;">Terakhir Ditambahkan</div>
                                            <div style="font-size: 14px; font-weight: 600; color: var(--dark);">
                                                {{ $datas->isNotEmpty() ? $datas->last()->created_at->diffForHumans() : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="d-flex align-items-center p-3 bg-light rounded-3" style="background: #F8FAFC; border-radius: var(--radius-sm);">
                                        <div class="me-3" style="width: 44px; height: 44px; background: #FEF3C7; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-clock-history text-warning" style="font-size: 20px;"></i>
                                        </div>
                                        <div>
                                            <div style="font-size: 12px; color: var(--secondary); font-weight: 500;">Terakhir Diupdate</div>
                                            <div style="font-size: 14px; font-weight: 600; color: var(--dark);">
                                                {{ $datas->isNotEmpty() ? $datas->sortByDesc('updated_at')->first()->updated_at->diffForHumans() : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table table-hover" id="table-jenis-usaha">
                                    <thead>
                                        <tr>
                                            <th style="width: 60px;" class="text-center">#</th>
                                            <th>Nama Jenis Usaha</th>
                                            <th>Deskripsi</th>
                                            <th style="width: 130px;" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($datas as $i => $data)
                                            <tr>
                                                <td class="text-center">
                                                    <span class="row-number">{{ ++$i }}</span>
                                                </td>
                                                <td>
                                                    <div style="font-weight: 600; color: var(--dark);">
                                                        {{ $data->nama_jenis ?? '-' }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="desc-text">
                                                        {!! $data->deskripsi ?? '<span style="color: #94A3B8; font-style: italic;">Tidak ada deskripsi</span>' !!}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="action-group justify-content-center">
                                                        <a href="{{ route('jenis_usaha.edit', $data->id) }}" 
                                                           class="action-btn edit" 
                                                           data-tooltip="Edit Data">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button onclick="deleteData({{ $data->id }}, 'jenis_usaha')" 
                                                                class="action-btn delete" 
                                                                data-tooltip="Hapus Data">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">
                                                    <div class="empty-state">
                                                        <i class="bi bi-inbox"></i>
                                                        <h5>Belum Ada Data</h5>
                                                        <p>Mulai tambahkan data jenis usaha pertama Anda</p>
                                                        <a href="{{ route('jenis_usaha.create') }}" class="btn-primary-custom" style="display: inline-flex; margin-top: 10px;">
                                                            <i class="bi bi-plus-circle"></i>
                                                            Tambah Data
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
        </section>
    </div>

    @push('scripts')
        <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('library/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('js/page/modules-datatables.js') }}"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                // Initialize DataTable with enhanced configuration
                var table = $('#table-jenis-usaha').DataTable({
                    paging: true,
                    searching: true,
                    ordering: true,
                    info: true,
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/2.1.0/i18n/id.json',
                        search: '<i class="bi bi-search me-2"></i>Pencarian Data Jenis Usaha',
                        searchPlaceholder: 'Cari nama atau deskripsi...',
                        lengthMenu: 'Tampilkan _MENU_ data per halaman',
                        info: 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
                        infoEmpty: 'Tidak ada data',
                        zeroRecords: 'Data tidak ditemukan',
                    },
                    dom: '<"top"lf>rt<"bottom"ip>',
                    pageLength: 10,
                    lengthMenu: [5, 10, 25, 50, 100],
                    columnDefs: [
                        {
                            targets: [0, 3],
                            orderable: false,
                        },
                        {
                            targets: 2,
                            render: function(data) {
                                if (data && data.trim() !== '') {
                                    return '<div class="desc-text">' + data + '</div>';
                                }
                                return '<span style="color: #94A3B8; font-style: italic;">Tidak ada deskripsi</span>';
                            }
                        }
                    ],
                    drawCallback: function() {
                        // Re-initialize tooltips after table redraw
                        $('[data-tooltip]').each(function() {
                            // Tooltip handled by CSS
                        });
                    }
                });

                // Add custom search styling
                $('.dataTables_filter input').attr('placeholder', 'Cari nama atau deskripsi...');

                // Add counter badge
                const totalRecords = {{ $datas->count() }};
                if (totalRecords > 0) {
                    $('.dataTables_info').prepend('<span class="badge-custom primary me-2">' + totalRecords + ' Total</span> ');
                }

                // Responsive adjustments
                function handleResponsive() {
                    if ($(window).width() < 768) {
                        $('.dataTables_filter input').css('min-width', '100%');
                    } else {
                        $('.dataTables_filter input').css('min-width', '250px');
                    }
                }

                handleResponsive();
                $(window).resize(handleResponsive);
            });

            // Delete function with confirmation
            function deleteData(id, type) {
                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: 'Apakah Anda yakin ingin menghapus data ini?',
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
                    }
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
                                    text: 'Data berhasil dihapus',
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
                                    text: 'Terjadi kesalahan saat menghapus data',
                                    confirmButtonColor: '#4F46E5',
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

        <!-- SweetAlert2 for better modals -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush
@endsection