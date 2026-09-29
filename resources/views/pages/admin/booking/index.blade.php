@extends('layouts.app', ['title' => 'Data Booking', 'menu' => 'booking'])

@section('content')
    <div class="main-content">
        <section class="section">
            <!-- Page Header -->
            <div class="section-header">
                <div class="d-flex align-items-center">
                    <div class="header-icon-box mr-3">
                        <span class="material-symbols-outlined">receipt_long</span>
                    </div>
                    <div>
                        <h1 class="mb-0">Data Booking</h1>
                        <div class="header-subtitle">Pantau seluruh reservasi tiket, status verifikasi, dan nomor kursi penumpang</div>
                    </div>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></div>
                    <div class="breadcrumb-item">Transaksi</div>
                    <div class="breadcrumb-item active">Booking</div>
                </div>
            </div>

            <!-- Filter Card -->
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <span class="material-symbols-outlined mr-2 text-primary" style="font-size: 18px;">tune</span>
                        <h4 class="mb-0">Filter Pemesanan</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.booking.index') }}" method="GET" class="form-row align-items-center">
                        <div class="col-md-3 col-12 mb-2">
                            <input type="text" name="kode_booking" class="form-control" placeholder="Cari kode booking..."
                                value="{{ $filter['kode_booking'] ?? '' }}">
                        </div>
                        <div class="col-md-3 col-12 mb-2">
                            <select name="status_booking" class="form-control">
                                <option value="">-- Status Booking --</option>
                                @foreach (['pending', 'confirmed', 'completed', 'cancelled', 'expired'] as $status)
                                    <option value="{{ $status }}" {{ ($filter['status_booking'] ?? '') == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 col-12 mb-2">
                            <select name="status_pembayaran" class="form-control">
                                <option value="">-- Status Bayar --</option>
                                @foreach (['paid', 'pending', 'failed', 'expired'] as $status)
                                    <option value="{{ $status }}" {{ ($filter['status_pembayaran'] ?? '') == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 col-12 mb-2 d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <span class="material-symbols-outlined" style="font-size: 16px;">filter_alt</span>
                                <span>Filter</span>
                            </button>
                            <a href="{{ route('admin.booking.index') }}" class="btn btn-secondary" title="Reset Filter">
                                <span class="material-symbols-outlined" style="font-size: 16px;">restart_alt</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table Card -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4>Daftar Transaksi Tiket</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Kode Booking</th>
                                    <th>Customer</th>
                                    <th>Rute</th>
                                    <th>Jadwal</th>
                                    <th>Kursi</th>
                                    <th>Total Tarif</th>
                                    <th>Status Booking</th>
                                    <th>Status Bayar</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($datas as $data)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.booking.show', $data->id) }}" class="font-weight-bold text-primary font-monospace" style="font-size: 13px;">
                                                #{{ $data->kode_booking }}
                                            </a>
                                        </td>
                                        <td class="font-weight-bold text-dark">{{ $data->user->name ?? 'Guest User' }}</td>
                                        <td>
                                            <div class="font-weight-bold text-dark">{{ $data->jadwal->rute->terminalAsal->kota }} &rarr; {{ $data->jadwal->rute->terminalTujuan->kota }}</div>
                                            <div class="text-muted small">{{ $data->jadwal->bus->nama_bus ?? '' }}</div>
                                        </td>
                                        <td>
                                            <div>{{ $data->jadwal->tanggal->format('d M Y') }}</div>
                                            <div class="text-muted small">{{ $data->jadwal->jam_berangkat->format('H:i') }} WIB</div>
                                        </td>
                                        <td>
                                            <span class="badge badge-primary font-weight-bold">
                                                {{ $data->bookingSeats->map(fn ($s) => $s->kursi->nomor_kursi)->join(', ') }}
                                            </span>
                                        </td>
                                        <td class="font-weight-bold text-dark">Rp {{ number_format($data->total_harga, 0, ',', '.') }}</td>
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
                                            <a href="{{ route('admin.booking.show', $data->id) }}" class="btn btn-sm btn-primary" title="Lihat Detail">
                                                <span class="material-symbols-outlined" style="font-size: 16px;">visibility</span>
                                                <span>Detail</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-5 text-muted">
                                            <span class="material-symbols-outlined text-muted" style="font-size: 36px; display: block; margin-bottom: 6px;">inbox</span>
                                            <span>Belum ada data booking</span>
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