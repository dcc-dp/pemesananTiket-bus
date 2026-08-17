@extends('layouts.user.app', ['title' => 'Tiket Saya'])

@section('content')
    <div class="main-content" style="padding-top: 30px;">
        <section class="section">
            <div class="section-header" style="background: transparent; box-shadow: none;">
                <h1><i class="fas fa-ticket-alt"></i> Tiket Saya</h1>
                <div class="section-header-button">
                    <a href="{{ route('tiket.search') }}" class="btn btn-primary" style="background: #1E5AA8; border: none;">
                        <i class="fas fa-plus"></i> Booking Baru
                    </a>
                </div>
            </div>

            @forelse ($bookings as $booking)
                <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px; overflow: hidden;">
                    <div style="background: linear-gradient(135deg, #0B1F3A 0%, #123E73 50%, #1E5AA8 100%); padding: 12px 20px; display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: #fff; font-weight: 700;"><i class="fas fa-ticket-alt"></i> {{ $booking->kode_booking }}</span>
                        <span style="color: rgba(255,255,255,0.85); font-size: 0.8rem;">{{ $booking->jadwal->bus->nama_bus }} &middot; {{ ucfirst($booking->jadwal->bus->kelas) }}</span>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-7">
                                <div class="d-flex align-items-center">
                                    <div class="text-center">
                                        <h5 class="font-weight-bold mb-0" style="color: #0B1F3A;">{{ $booking->jadwal->jam_berangkat->format('H:i') }}</h5>
                                        <small class="text-muted">{{ $booking->jadwal->rute->terminalAsal->kota }}</small>
                                    </div>
                                    <div class="mx-3 text-center flex-grow-1">
                                        <div class="small text-muted">{{ $booking->jadwal->tanggal->format('d M Y') }}</div>
                                        <div style="border-top: 2px dashed #1E5AA8; position: relative; margin: 6px 0;">
                                            <i class="fas fa-circle" style="position: absolute; top: -5px; left: 0; color: #1E5AA8; font-size: 0.5rem;"></i>
                                            <i class="fas fa-bus" style="position: absolute; top: -9px; right: 0; color: #1E5AA8; font-size: 0.8rem;"></i>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <h5 class="font-weight-bold mb-0" style="color: #0B1F3A;">{{ \Carbon\Carbon::parse($booking->jadwal->jam_berangkat)->addMinutes($booking->jadwal->rute->estimasi_durasi ?? 0)->format('H:i') }}</h5>
                                        <small class="text-muted">{{ $booking->jadwal->rute->terminalTujuan->kota }}</small>
                                    </div>
                                </div>
                                <div class="small text-muted mt-2">
                                    <i class="fas fa-chair"></i> Kursi: {{ $booking->bookingSeats->map(fn ($s) => $s->kursi->nomor_kursi)->join(', ') }}
                                    &middot; {{ $booking->bookingSeats->count() }} penumpang
                                </div>
                            </div>
                            <div class="col-md-5 text-right">
                                <div class="small text-muted">Total Dibayar</div>
                                <div class="h5 font-weight-bold" style="color: #1E5AA8;">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</div>
                                <a href="{{ route('customer.booking.ticket', $booking->id) }}" class="btn btn-primary btn-sm font-weight-bold mt-2" style="background: #1E5AA8; border: none;">
                                    <i class="fas fa-ticket-alt"></i> Lihat / Cetak Tiket
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-ticket-alt" style="font-size: 3rem; color: #c0c9d6;"></i>
                        <h6 class="mt-3 font-weight-bold" style="color: #0B1F3A;">Belum Ada Tiket</h6>
                        <p class="text-muted">Anda belum memiliki tiket yang lunas.</p>
                        <a href="{{ route('tiket.search') }}" class="btn btn-primary" style="background: #1E5AA8; border: none;">Cari Tiket</a>
                    </div>
                </div>
            @endforelse
        </section>
    </div>
@endsection