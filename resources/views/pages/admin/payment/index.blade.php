@extends('layouts.app', ['title' => 'Data Pembayaran', 'menu' => 'payment'])

@section('content')
    <div class="main-content">
        <section class="section">
            <!-- Page Header -->
            <div class="section-header">
                <div class="d-flex align-items-center">
                    <div class="header-icon-box mr-3">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                    <div>
                        <h1 class="mb-0">Data Pembayaran</h1>
                        <div class="header-subtitle">Kelola transaksi pembayaran, status payment gateway, dan rincian transaksi</div>
                    </div>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></div>
                    <div class="breadcrumb-item">Transaksi</div>
                    <div class="breadcrumb-item active">Pembayaran</div>
                </div>
            </div>

            <!-- Filter Card -->
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <span class="material-symbols-outlined mr-2 text-primary" style="font-size: 18px;">tune</span>
                        <h4 class="mb-0">Filter Pembayaran</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.payment.index') }}" method="GET" class="form-row align-items-center">
                        <div class="col-md-4 col-12 mb-2">
                            <select name="payment_status" class="form-control">
                                <option value="">-- Semua Status --</option>
                                @foreach (['paid', 'pending', 'failed'] as $status)
                                    <option value="{{ $status }}" {{ ($filter['payment_status'] ?? '') == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-12 mb-2">
                            <select name="payment_type" class="form-control">
                                <option value="">-- Semua Metode --</option>
                                @foreach (['cash', 'transfer', 'qris', 'midtrans'] as $type)
                                    <option value="{{ $type }}" {{ ($filter['payment_type'] ?? '') == $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-12 mb-2 d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <span class="material-symbols-outlined" style="font-size: 16px;">filter_alt</span>
                                <span>Filter</span>
                            </button>
                            <a href="{{ route('admin.payment.index') }}" class="btn btn-secondary" title="Reset Filter">
                                <span class="material-symbols-outlined" style="font-size: 16px;">restart_alt</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table Card -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4>Daftar Riwayat Pembayaran</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Kode Booking</th>
                                    <th>Metode</th>
                                    <th>Jumlah Bayar</th>
                                    <th>Status</th>
                                    <th>Waktu Pembayaran</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($datas as $data)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.payment.show', $data->id) }}" class="font-weight-bold text-primary font-monospace" style="font-size: 13px;">
                                                {{ $data->order_id }}
                                            </a>
                                        </td>
                                        <td class="font-weight-bold text-dark">{{ $data->booking->user->name ?? 'Guest User' }}</td>
                                        <td><span class="badge badge-secondary">{{ $data->booking->kode_booking ?? '-' }}</span></td>
                                        <td><span class="badge badge-primary">{{ $data->payment_type ? ucfirst($data->payment_type) : '-' }}</span></td>
                                        <td class="font-weight-bold text-dark">Rp {{ number_format($data->gross_amount, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge badge-{{ $data->payment_status == 'paid' ? 'success' : ($data->payment_status == 'pending' ? 'warning' : 'danger') }}">
                                                {{ $data->payment_status_label }}
                                            </span>
                                        </td>
                                        <td>{{ $data->paid_at ? $data->paid_at->format('d M Y H:i') : '-' }}</td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.payment.show', $data->id) }}" class="btn btn-sm btn-primary" title="Lihat Detail">
                                                <span class="material-symbols-outlined" style="font-size: 16px;">visibility</span>
                                                <span>Detail</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5 text-muted">
                                            <span class="material-symbols-outlined text-muted" style="font-size: 36px; display: block; margin-bottom: 6px;">inbox</span>
                                            <span>Belum ada data pembayaran</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($datas->hasPages())
                        <div class="p-3 border-top">
                            {{ $datas->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection