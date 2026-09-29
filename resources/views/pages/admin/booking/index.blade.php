@extends('layouts.app', ['title' => 'Data Booking'])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-file-invoice"></i> Data Booking</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Transaksi</div>
                    <div class="breadcrumb-item">Booking</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>Filter</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.booking.index') }}" method="GET" class="form-inline">
                        <input type="text" name="kode_booking" class="form-control mr-2 mb-2" placeholder="Cari kode booking"
                            value="{{ $filter['kode_booking'] ?? '' }}">
                        <select name="status_booking" class="form-control mr-2 mb-2">
                            <option value="">-- Semua Status Booking --</option>
                            @foreach (['pending', 'confirmed', 'completed', 'cancelled', 'expired'] as $status)
                                <option value="{{ $status }}" {{ ($filter['status_booking'] ?? '') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                        <select name="status_pembayaran" class="form-control mr-2 mb-2">
                            <option value="">-- Semua Status Bayar --</option>
                            @foreach (['paid', 'pending', 'failed', 'expired'] as $status)
                                <option value="{{ $status }}" {{ ($filter['status_pembayaran'] ?? '') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary mb-2" style="background: #1E5AA8; border: none;">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('admin.booking.index') }}" class="btn btn-secondary mb-2 ml-1">Reset</a>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>Daftar Booking</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead style="background: #f8fafc;">
                                <tr>
                                    <th>Kode</th>
                                    <th>Customer</th>
                                    <th>Rute</th>
                                    <th>Jadwal</th>
                                    <th>Kursi</th>
                                    <th>Total</th>
                                    <th>Status Booking</th>
                                    <th>Status Bayar</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($datas as $data)
                                    <tr>
                                        <td><span class="badge badge-primary">{{ $data->kode_booking }}</span></td>
                                        <td>{{ $data->user->name }}</td>
                                        <td>{{ $data->jadwal->rute->terminalAsal->kota }} &rarr; {{ $data->jadwal->rute->terminalTujuan->kota }}</td>
                                        <td>{{ $data->jadwal->tanggal->format('d M Y') }}<br><small class="text-muted">{{ $data->jadwal->jam_berangkat->format('H:i') }}</small></td>
                                        <td>{{ $data->bookingSeats->map(fn ($s) => $s->kursi->nomor_kursi)->join(', ') }}</td>
                                        <td class="font-weight-bold">Rp {{ number_format($data->total_harga, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge badge-{{ $data->status_booking == 'confirmed' || $data->status_booking == 'completed' ? 'success' : ($data->status_booking == 'pending' ? 'warning' : 'danger') }}">
                                                {{ $data->status_booking_label }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $data->status_pembayaran == 'paid' ? 'success' : ($data->status_pembayaran == 'pending' ? 'warning' : 'danger') }}">
                                                {{ $data->status_pembayaran_label }}
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.booking.show', $data->id) }}" class="btn btn-sm btn-primary" style="background: #1E5AA8; border: none;">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4 text-muted">Belum ada data booking</td>
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