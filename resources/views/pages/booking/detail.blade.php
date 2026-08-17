@extends('layouts.landing.app', ['menu' => 'booking'])

@section('content')
    <div style="background: linear-gradient(135deg, #0B1F3A 0%, #123E73 50%, #1E5AA8 100%); padding: 40px 0; margin-bottom: 30px;">
        <div class="container">
            <div class="d-flex align-items-center">
                <a href="{{ Session('role') == 'admin' ? route('admin.booking.show', $booking->id) : route('customer.bookings') }}" class="btn btn-sm btn-outline-light mr-3"><i class="fas fa-arrow-left"></i></a>
                <div>
                    <h5 class="text-white font-weight-bold mb-0"><i class="fas fa-file-invoice"></i> Detail Booking</h5>
                    <small class="text-white-50">Kode Booking: <strong class="text-white">{{ $booking->kode_booking }}</strong></small>
                </div>
                <div class="ml-auto">
                    @if ($booking->status_pembayaran == 'paid')
                        <span class="badge badge-success badge-lg" style="font-size: 1rem;"><i class="fas fa-check-circle"></i> LUNAS</span>
                    @elseif ($booking->status_pembayaran == 'pending')
                        <span class="badge badge-warning badge-lg" style="font-size: 1rem;"><i class="fas fa-clock"></i> MENUNGGU PEMBAYARAN</span>
                    @elseif ($booking->status_pembayaran == 'failed')
                        <span class="badge badge-danger badge-lg" style="font-size: 1rem;"><i class="fas fa-times-circle"></i> GAGAL</span>
                    @elseif ($booking->status_booking == 'expired')
                        <span class="badge badge-secondary badge-lg" style="font-size: 1rem;"><i class="fas fa-hourglass-end"></i> EXPIRED</span>
                    @elseif ($booking->status_booking == 'cancelled')
                        <span class="badge badge-danger badge-lg" style="font-size: 1rem;"><i class="fas fa-ban"></i> DIBATALKAN</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="margin-bottom: 60px;">
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
                    <div class="card-body">
                        <h6 class="font-weight-bold" style="color: #0B1F3A;"><i class="fas fa-route"></i> Jadwal Perjalanan</h6>
                        <hr>
                        <div class="row text-center">
                            <div class="col-md-4">
                                <h5 class="font-weight-bold mb-0" style="color: #0B1F3A;">{{ $booking->jadwal->jam_berangkat->format('H:i') }}</h5>
                                <small class="text-muted">{{ $booking->jadwal->rute->terminalAsal->nama_terminal }}</small>
                                <div class="text-muted small">{{ $booking->jadwal->rute->terminalAsal->kota }}</div>
                            </div>
                            <div class="col-md-4 d-flex align-items-center justify-content-center">
                                <div class="w-100">
                                    <div class="small text-muted">{{ $booking->jadwal->tanggal->format('d M Y') }}</div>
                                    <div style="border-top: 2px dashed #1E5AA8; position: relative; margin: 8px 0;">
                                        <i class="fas fa-circle" style="position: absolute; top: -6px; left: 0; color: #1E5AA8; font-size: 0.5rem;"></i>
                                        <i class="fas fa-bus" style="position: absolute; top: -9px; right: 0; color: #1E5AA8; font-size: 0.8rem;"></i>
                                    </div>
                                    <div class="small text-muted">{{ $booking->jadwal->rute->estimasi_durasi ? \Carbon\Carbon::parse($booking->jadwal->rute->estimasi_durasi)->format('H:i') . ' jam' : '' }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h5 class="font-weight-bold mb-0" style="color: #0B1F3A;">{{ \Carbon\Carbon::parse($booking->jadwal->jam_berangkat)->addMinutes($booking->jadwal->rute->estimasi_durasi ?? 0)->format('H:i') }}</h5>
                                <small class="text-muted">{{ $booking->jadwal->rute->terminalTujuan->nama_terminal }}</small>
                                <div class="text-muted small">{{ $booking->jadwal->rute->terminalTujuan->kota }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
                    <div class="card-body">
                        <h6 class="font-weight-bold" style="color: #0B1F3A;"><i class="fas fa-users"></i> Data Penumpang ({{ $booking->bookingSeats->count() }})</h6>
                        <hr>
                        @foreach ($booking->bookingSeats as $seat)
                            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                <div>
                                    <div class="font-weight-bold" style="color: #0B1F3A;">
                                        <i class="fas fa-chair"></i> Kursi {{ $seat->kursi->nomor_kursi }} &mdash; {{ $seat->nama_penumpang }}
                                    </div>
                                    <small class="text-muted">
                                        NIK: {{ $seat->nik }} &middot; {{ $seat->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }} &middot; {{ $seat->tanggal_lahir->format('d M Y') }}
                                    </small>
                                </div>
                                <span class="font-weight-bold" style="color: #1E5AA8;">Rp {{ number_format($seat->harga, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="font-weight-bold" style="color: #0B1F3A;">Total</span>
                            <span class="h4 font-weight-bold mb-0" style="color: #1E5AA8;">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm sticky-top" style="border-radius: 12px; top: 20px;">
                    <div class="card-body">
                        <h6 class="font-weight-bold" style="color: #0B1F3A;"><i class="fas fa-info-circle"></i> Status Pemesanan</h6>
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Status Booking</span>
                            <span class="badge badge-{{ in_array($booking->status_booking, ['confirmed', 'completed']) ? 'success' : 'secondary' }}">
                                {{ $booking->status_booking_label }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Status Pembayaran</span>
                            <span class="badge badge-{{ $booking->status_pembayaran == 'paid' ? 'success' : 'warning' }}">
                                {{ $booking->status_pembayaran_label }}
                            </span>
                        </div>
                        @if ($booking->payment_method)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Metode</span>
                                <span class="font-weight-bold">{{ ucfirst($booking->payment_method) }}</span>
                            </div>
                        @endif
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Bus</span>
                            <span class="font-weight-bold">{{ $booking->jadwal->bus->nama_bus }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Plat Nomor</span>
                            <span class="font-weight-bold">{{ $booking->jadwal->bus->nomor_polisi }}</span>
                        </div>
                        @if ($booking->expired_at && now()->lt($booking->expired_at))
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Batas Bayar</span>
                                <span class="font-weight-bold">{{ $booking->expired_at->format('d M H:i') }}</span>
                            </div>
                        @endif
                        <hr>
                        @if ($booking->status_pembayaran == 'paid')
                            <a href="{{ route('customer.booking.ticket', $booking->id) }}" class="btn btn-success btn-block font-weight-bold">
                                <i class="fas fa-ticket-alt"></i> Lihat Tiket
                            </a>
                        @elseif ($booking->status_pembayaran == 'pending')
                            <a href="{{ route('customer.booking.pay', $booking->id) }}" class="btn btn-primary btn-block font-weight-bold" style="background: linear-gradient(135deg, #123E73, #1E5AA8); border: none;">
                                <i class="fas fa-credit-card"></i> Bayar Sekarang
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection