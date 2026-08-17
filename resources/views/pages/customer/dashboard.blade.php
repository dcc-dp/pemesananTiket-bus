@extends('layouts.user.app', ['title' => 'Dashboard'])

@section('content')
    <div class="main-content" style="padding-top: 30px;">
        <section class="section">
            <div class="section-header" style="background: transparent; box-shadow: none;">
                <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
            </div>

            <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #0B1F3A 0%, #123E73 50%, #1E5AA8 100%); border-radius: 16px;">
                <div class="card-body text-white p-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div>
                            <h4 class="font-weight-bold mb-1">Halo, {{ $user->name }}!</h4>
                            <p class="mb-0" style="color: rgba(255,255,255,0.8);">Selamat datang kembali. Siap untuk perjalanan berikutnya?</p>
                        </div>
                        <a href="{{ route('tiket.search') }}" class="btn btn-light font-weight-bold mt-3 mt-md-0">
                            <i class="fas fa-search"></i> Cari Tiket Sekarang
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-muted small">Tiket Terbayar</div>
                                    <div class="h3 font-weight-bold mb-0" style="color: #0B1F3A;">{{ $paidBookings }}</div>
                                </div>
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: rgba(45,206,137,0.15); color: #2dce89;">
                                    <i class="fas fa-ticket-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-muted small">Total Perjalanan</div>
                                    <div class="h3 font-weight-bold mb-0" style="color: #0B1F3A;">{{ $totalPerjalanan }}</div>
                                </div>
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: rgba(30,90,168,0.15); color: #1E5AA8;">
                                    <i class="fas fa-bus"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-muted small">Booking Aktif</div>
                                    <div class="h3 font-weight-bold mb-0" style="color: #0B1F3A;">{{ $activeBookings->count() }}</div>
                                </div>
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: rgba(246,194,62,0.2); color: #f6c23e;">
                                    <i class="fas fa-file-invoice"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white d-flex justify-content-between align-items-center" style="border-radius: 12px 12px 0 0;">
                    <h6 class="font-weight-bold mb-0" style="color: #0B1F3A;">Booking Terbaru</h6>
                    <a href="{{ route('customer.bookings') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    @if ($activeBookings->count() === 0)
                        <div class="text-center py-5">
                            <i class="fas fa-ticket-alt" style="font-size: 2.5rem; color: #c0c9d6;"></i>
                            <p class="text-muted mt-3 mb-0">Belum ada booking. Yuk mulai cari tiket!</p>
                            <a href="{{ route('tiket.search') }}" class="btn btn-primary mt-3" style="background: #1E5AA8; border: none;">Cari Tiket</a>
                        </div>
                    @else
                        <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background: #f8fafc;">
                                <tr>
                                    <th>Kode</th>
                                    <th>Rute</th>
                                    <th>Jadwal</th>
                                    <th>Status</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($activeBookings as $booking)
                                    <tr>
                                        <td><span class="badge badge-primary">{{ $booking->kode_booking }}</span></td>
                                        <td>{{ $booking->jadwal->rute->terminalAsal->kota }} &rarr; {{ $booking->jadwal->rute->terminalTujuan->kota }}</td>
                                        <td>{{ $booking->jadwal->tanggal->format('d M') }} &middot; {{ $booking->jadwal->jam_berangkat->format('H:i') }}</td>
                                        <td>
                                            @if ($booking->status_pembayaran == 'paid')
                                                <span class="badge badge-success">Lunas</span>
                                            @elseif ($booking->status_pembayaran == 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @else
                                                <span class="badge badge-secondary">{{ $booking->status_booking }}</span>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('customer.booking.detail', $booking->id) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection