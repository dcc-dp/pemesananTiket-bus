@extends('layouts.app', ['title' => 'Detail Pembayaran'])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-credit-card"></i> Detail Pembayaran</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Transaksi</div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.payment.index') }}">Pembayaran</a></div>
                    <div class="breadcrumb-item">{{ $data->order_id }}</div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Informasi Pembayaran</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text-muted" style="width: 40%;">Order ID</td>
                                        <td class="font-weight-bold">{{ $data->order_id }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Transaction ID</td>
                                        <td>{{ $data->transaction_id ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Metode</td>
                                        <td>{{ $data->payment_type ? ucfirst($data->payment_type) : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Jumlah</td>
                                        <td class="font-weight-bold" style="color: #1E5AA8;">Rp {{ number_format($data->gross_amount, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Transaction Status</td>
                                        <td>{{ $data->transaction_status ? ucfirst($data->transaction_status) : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Payment Status</td>
                                        <td>
                                            <span class="badge badge-{{ $data->payment_status == 'paid' ? 'success' : ($data->payment_status == 'pending' ? 'warning' : 'danger') }}">
                                                {{ $data->payment_status_label }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Waktu Dibayar</td>
                                        <td>{{ $data->paid_at ? $data->paid_at->format('d M Y H:i') : '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Informasi Booking</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text-muted" style="width: 40%;">Kode Booking</td>
                                        <td class="font-weight-bold">
                                            <a href="{{ route('admin.booking.show', $data->booking->id) }}">{{ $data->booking->kode_booking }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Customer</td>
                                        <td>{{ $data->booking->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Rute</td>
                                        <td>{{ $data->booking->jadwal->rute->terminalAsal->kota }} &rarr; {{ $data->booking->jadwal->rute->terminalTujuan->kota }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Jadwal</td>
                                        <td>{{ $data->booking->jadwal->tanggal->format('d M Y') }} &middot; {{ $data->booking->jadwal->jam_berangkat->format('H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Bus</td>
                                        <td>{{ $data->booking->jadwal->bus->nama_bus }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection