@extends('layouts.user.app', ['title' => 'Booking Saya'])

@section('content')
    <div class="main-content" style="padding-top: 30px;">
        <section class="section">
            <div class="section-header" style="background: transparent; box-shadow: none;">
                <h1><i class="fas fa-file-invoice"></i> Booking Saya</h1>
                <div class="section-header-button">
                    <a href="{{ route('tiket.search') }}" class="btn btn-primary" style="background: #1E5AA8; border: none;">
                        <i class="fas fa-plus"></i> Booking Baru
                    </a>
                </div>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('customer.bookings') }}" class="btn btn-sm {{ !$filter ? 'btn-primary' : 'btn-outline-primary' }}" style="{{ !$filter ? 'background:#1E5AA8;border:none;' : '' }}">Semua</a>
                        <a href="{{ route('customer.bookings', ['status' => 'pending']) }}" class="btn btn-sm {{ $filter == 'pending' ? 'btn-primary' : 'btn-outline-primary' }}" style="{{ $filter == 'pending' ? 'background:#1E5AA8;border:none;' : '' }}">Pending</a>
                        <a href="{{ route('customer.bookings', ['status' => 'confirmed']) }}" class="btn btn-sm {{ $filter == 'confirmed' ? 'btn-primary' : 'btn-outline-primary' }}" style="{{ $filter == 'confirmed' ? 'background:#1E5AA8;border:none;' : '' }}">Confirmed</a>
                        <a href="{{ route('customer.bookings', ['status' => 'completed']) }}" class="btn btn-sm {{ $filter == 'completed' ? 'btn-primary' : 'btn-outline-primary' }}" style="{{ $filter == 'completed' ? 'background:#1E5AA8;border:none;' : '' }}">Completed</a>
                        <a href="{{ route('customer.bookings', ['status' => 'cancelled']) }}" class="btn btn-sm {{ $filter == 'cancelled' ? 'btn-primary' : 'btn-outline-primary' }}" style="{{ $filter == 'cancelled' ? 'background:#1E5AA8;border:none;' : '' }}">Batal</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead style="background: #f8fafc;">
                                <tr>
                                    <th>Kode Booking</th>
                                    <th>Rute</th>
                                    <th>Jadwal</th>
                                    <th>Kursi</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Dibuat</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bookings as $booking)
                                    <tr>
                                        <td><span class="badge badge-primary">{{ $booking->kode_booking }}</span></td>
                                        <td>
                                            {{ $booking->jadwal->rute->terminalAsal->kota }} &rarr; {{ $booking->jadwal->rute->terminalTujuan->kota }}
                                            <div class="small text-muted">{{ $booking->jadwal->bus->nama_bus }}</div>
                                        </td>
                                        <td>{{ $booking->jadwal->tanggal->format('d M Y') }}<br><small class="text-muted">{{ $booking->jadwal->jam_berangkat->format('H:i') }}</small></td>
                                        <td>{{ $booking->bookingSeats->map(fn ($s) => $s->kursi->nomor_kursi)->join(', ') }}</td>
                                        <td class="font-weight-bold">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($booking->status_booking == 'confirmed' || $booking->status_booking == 'completed')
                                                <span class="badge badge-success">{{ $booking->status_booking_label }}</span>
                                            @elseif ($booking->status_booking == 'pending')
                                                <span class="badge badge-warning">{{ $booking->status_booking_label }}</span>
                                            @else
                                                <span class="badge badge-secondary">{{ $booking->status_booking_label }}</span>
                                            @endif
                                            @if ($booking->status_pembayaran == 'paid')
                                                <span class="badge badge-success">Lunas</span>
                                            @else
                                                <span class="badge badge-warning">{{ $booking->status_pembayaran_label }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $booking->tanggal_booking->format('d M Y H:i') }}</td>
                                        <td class="text-right">
                                            <a href="{{ route('customer.booking.detail', $booking->id) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                                            @if ($booking->status_pembayaran == 'pending')
                                                <a href="{{ route('customer.booking.pay', $booking->id) }}" class="btn btn-sm btn-primary" style="background: #1E5AA8; border: none;">Bayar</a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5 text-muted">
                                            <i class="fas fa-inbox" style="font-size: 2rem;"></i>
                                            <p class="mt-3 mb-0">Belum ada booking.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $bookings->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection