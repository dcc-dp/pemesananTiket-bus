@extends('layouts.app', ['title' => 'Data Pembayaran'])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-credit-card"></i> Data Pembayaran</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Transaksi</div>
                    <div class="breadcrumb-item">Pembayaran</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>Filter</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.payment.index') }}" method="GET" class="form-inline">
                        <select name="payment_status" class="form-control mr-2 mb-2">
                            <option value="">-- Semua Status --</option>
                            @foreach (['paid', 'pending', 'failed'] as $status)
                                <option value="{{ $status }}" {{ ($filter['payment_status'] ?? '') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                        <select name="payment_type" class="form-control mr-2 mb-2">
                            <option value="">-- Semua Metode --</option>
                            @foreach (['cash', 'transfer', 'qris', 'midtrans'] as $type)
                                <option value="{{ $type }}" {{ ($filter['payment_type'] ?? '') == $type ? 'selected' : '' }}>
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary mb-2" style="background: #1E5AA8; border: none;">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('admin.payment.index') }}" class="btn btn-secondary mb-2 ml-1">Reset</a>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>Daftar Pembayaran</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead style="background: #f8fafc;">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Booking</th>
                                    <th>Metode</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Dibayar</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($datas as $data)
                                    <tr>
                                        <td><span class="badge badge-secondary">{{ $data->order_id }}</span></td>
                                        <td>{{ $data->booking->user->name }}</td>
                                        <td>{{ $data->booking->kode_booking }}</td>
                                        <td>{{ $data->payment_type ? ucfirst($data->payment_type) : '-' }}</td>
                                        <td class="font-weight-bold">Rp {{ number_format($data->gross_amount, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge badge-{{ $data->payment_status == 'paid' ? 'success' : ($data->payment_status == 'pending' ? 'warning' : 'danger') }}">
                                                {{ $data->payment_status_label }}
                                            </span>
                                        </td>
                                        <td>{{ $data->paid_at ? $data->paid_at->format('d M Y H:i') : '-' }}</td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.payment.show', $data->id) }}" class="btn btn-sm btn-primary" style="background: #1E5AA8; border: none;">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">Belum ada data pembayaran</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3">
                        {{ $datas->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection