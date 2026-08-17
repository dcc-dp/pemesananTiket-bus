@extends('layouts.app', ['title' => 'Detail Booking'])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-file-invoice"></i> Detail Booking</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Transaksi</div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.booking.index') }}">Booking</a></div>
                    <div class="breadcrumb-item">{{ $data->kode_booking }}</div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Informasi Perjalanan</h4>
                        </div>
                        <div class="card-body">
                            <div class="row text-center mb-3">
                                <div class="col-md-4">
                                    <h5 class="font-weight-bold mb-0">{{ $data->jadwal->jam_berangkat->format('H:i') }}</h5>
                                    <small class="text-muted">{{ $data->jadwal->rute->terminalAsal->nama_terminal }}</small>
                                    <div class="text-muted">{{ $data->jadwal->rute->terminalAsal->kota }}</div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center justify-content-center">
                                    <div class="w-100">
                                        <div class="small text-muted">{{ $data->jadwal->tanggal->format('d M Y') }}</div>
                                        <div style="border-top: 2px dashed #1E5AA8; position: relative; margin: 8px 0;">
                                            <i class="fas fa-circle" style="position: absolute; top: -6px; left: 0; color: #1E5AA8; font-size: 0.5rem;"></i>
                                            <i class="fas fa-bus" style="position: absolute; top: -9px; right: 0; color: #1E5AA8; font-size: 0.8rem;"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h5 class="font-weight-bold mb-0">{{ $data->jadwal->jam_tiba ? $data->jadwal->jam_tiba->format('H:i') : '-' }}</h5>
                                    <small class="text-muted">{{ $data->jadwal->rute->terminalTujuan->nama_terminal }}</small>
                                    <div class="text-muted">{{ $data->jadwal->rute->terminalTujuan->kota }}</div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-2"><span class="text-muted">Bus:</span> <strong>{{ $data->jadwal->bus->nama_bus }} ({{ $data->jadwal->bus->nomor_polisi }})</strong></div>
                                    <div class="mb-2"><span class="text-muted">Operator:</span> <strong>{{ $data->jadwal->bus->operator->nama_operator }}</strong></div>
                                    <div class="mb-2"><span class="text-muted">Kelas:</span> <strong>{{ ucfirst($data->jadwal->bus->kelas) }}</strong></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2"><span class="text-muted">Kode Booking:</span> <strong>{{ $data->kode_booking }}</strong></div>
                                    <div class="mb-2"><span class="text-muted">Dibuat:</span> <strong>{{ $data->tanggal_booking->format('d M Y H:i') }}</strong></div>
                                    @if ($data->paid_at)
                                        <div class="mb-2"><span class="text-muted">Dibayar:</span> <strong>{{ $data->paid_at->format('d M Y H:i') }}</strong></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4>Data Penumpang ({{ $data->bookingSeats->count() }})</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead style="background: #f8fafc;">
                                        <tr>
                                            <th>Kursi</th>
                                            <th>Nama</th>
                                            <th>NIK</th>
                                            <th>No. HP</th>
                                            <th>JK</th>
                                            <th>Tgl Lahir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data->bookingSeats as $seat)
                                            <tr>
                                                <td><span class="badge badge-primary">{{ $seat->kursi->nomor_kursi }}</span></td>
                                                <td class="font-weight-bold">{{ $seat->nama_penumpang }}</td>
                                                <td>{{ $seat->nik }}</td>
                                                <td>{{ $seat->no_hp }}</td>
                                                <td>{{ $seat->jenis_kelamin }}</td>
                                                <td>{{ $seat->tanggal_lahir->format('d M Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Status Pemesanan</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Status Booking</span>
                                <span class="badge badge-{{ in_array($data->status_booking, ['confirmed', 'completed']) ? 'success' : ($data->status_booking == 'pending' ? 'warning' : 'danger') }}">
                                    {{ $data->status_booking_label }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Status Bayar</span>
                                <span class="badge badge-{{ $data->status_pembayaran == 'paid' ? 'success' : ($data->status_pembayaran == 'pending' ? 'warning' : 'danger') }}">
                                    {{ $data->status_pembayaran_label }}
                                </span>
                            </div>
                            @if ($data->payment)
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Order ID</span>
                                    <span class="font-weight-bold">{{ $data->payment->order_id }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Metode</span>
                                    <span class="font-weight-bold">{{ $data->payment->payment_type ? ucfirst($data->payment->payment_type) : '-' }}</span>
                                </div>
                            @endif
                            <hr>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="font-weight-bold">Total</span>
                                <span class="h4 font-weight-bold mb-0" style="color: #1E5AA8;">Rp {{ number_format($data->total_harga, 0, ',', '.') }}</span>
                            </div>

                            @if ($data->status_booking == 'pending' && $data->status_pembayaran == 'pending')
                                <form method="POST" action="{{ route('admin.booking.confirm-payment', $data->id) }}" class="mb-2">
                                    @csrf
                                    <div class="form-group mb-2">
                                        <label>Metode Pembayaran</label>
                                        <input type="text" name="payment_method" class="form-control" placeholder="cash / transfer / midtrans" required>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-block font-weight-bold" onclick="return confirm('Konfirmasi pembayaran diterima?');">
                                        <i class="fas fa-check-circle"></i> Konfirmasi Pembayaran
                                    </button>
                                </form>
                            @endif

                            @if (in_array($data->status_booking, ['pending', 'confirmed']))
                                <form method="POST" action="{{ route('admin.booking.status', $data->id) }}" class="mb-2">
                                    @csrf
                                    <input type="hidden" name="status_booking" value="completed">
                                    <button type="submit" class="btn btn-primary btn-block font-weight-bold" style="background: #1E5AA8; border: none;"
                                        onclick="return confirm('Tandai booking selesai?');">
                                        <i class="fas fa-check"></i> Tandai Selesai
                                    </button>
                                </form>
                            @endif

                            @if (!in_array($data->status_booking, ['cancelled', 'expired']))
                                <form method="POST" action="{{ route('admin.booking.cancel', $data->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-block font-weight-bold" onclick="return confirm('Batalkan booking ini? Kursi akan dilepas.');">
                                        <i class="fas fa-ban"></i> Batalkan Booking
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection