@extends('layouts.landing.app', ['menu' => 'booking'])

@section('content')
    <div style="background: linear-gradient(135deg, #0B1F3A 0%, #123E73 50%, #1E5AA8 100%); padding: 40px 0; margin-bottom: 30px;">
        <div class="container">
            <h5 class="text-white font-weight-bold mb-0"><i class="fas fa-credit-card"></i> Pembayaran</h5>
            <small class="text-white-50">Kode Booking: <strong class="text-white">{{ $booking->kode_booking }}</strong></small>
        </div>
    </div>

    <div class="container" style="margin-bottom: 60px;">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body p-4">
                        @if ($booking->expired_at && now()->lt($booking->expired_at))
                            <div class="alert alert-info d-flex justify-content-between align-items-center mb-4">
                                <span><i class="fas fa-clock"></i> Selesaikan pembayaran sebelum</span>
                                <strong>{{ $booking->expired_at->format('d M Y H:i') }} WITA</strong>
                            </div>
                        @endif

                        <h6 class="font-weight-bold" style="color: #0B1F3A;">Ringkasan Pesanan</h6>
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Rute</span>
                            <span class="font-weight-bold">{{ $booking->jadwal->rute->terminalAsal->kota }} &rarr; {{ $booking->jadwal->rute->terminalTujuan->kota }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Jadwal</span>
                            <span class="font-weight-bold">{{ $booking->jadwal->tanggal->format('d M Y') }} &middot; {{ $booking->jadwal->jam_berangkat->format('H:i') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Bus</span>
                            <span class="font-weight-bold">{{ $booking->jadwal->bus->nama_bus }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Kursi</span>
                            <span class="font-weight-bold">{{ $booking->bookingSeats->map(fn ($s) => $s->kursi->nomor_kursi)->join(', ') }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold" style="color: #0B1F3A;">Total Pembayaran</span>
                            <span class="h4 font-weight-bold mb-0" style="color: #1E5AA8;">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mt-3" style="border-radius: 12px;">
                    <div class="card-body p-4">
                        @if ($midtransConfigured && $snapToken)
                            <h6 class="font-weight-bold" style="color: #0B1F3A;">Pilih Metode Pembayaran</h6>
                            <hr>
                            <button id="pay-button" class="btn btn-primary btn-lg btn-block font-weight-bold" style="background: linear-gradient(135deg, #123E73, #1E5AA8); border: none;">
                                <i class="fas fa-credit-card"></i> Bayar Sekarang
                            </button>
                            <small class="text-muted d-block text-center mt-2">
                                Anda akan diarahkan ke halaman pembayaran yang aman.
                            </small>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-hand-holding-usd" style="font-size: 2.5rem; color: #1E5AA8;"></i>
                                <h6 class="font-weight-bold mt-3" style="color: #0B1F3A;">Pembayaran di Loket</h6>
                                <p style="color: #6C757D;">
                                    Silakan lakukan pembayaran tunai di loket / agen BusTicket terdekat dengan menunjukkan
                                    <strong>Kode Booking {{ $booking->kode_booking }}</strong>.
                                    Pesanan Anda akan dikonfirmasi oleh admin setelah pembayaran diverifikasi.
                                </p>
                                <a href="{{ route('customer.booking.detail', $booking->id) }}" class="btn btn-outline-primary font-weight-bold">
                                    Lihat Detail Pesanan
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@if ($midtransConfigured && $snapToken)
    @push('scripts')
        <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"></script>
        <script type="text/javascript">
            document.getElementById('pay-button').onclick = function() {
                snap.pay('{{ $snapToken }}', {
                    onSuccess: function() { window.location.href = '{{ route("customer.booking.detail", $booking->id) }}'; },
                    onPending: function() { window.location.href = '{{ route("customer.booking.detail", $booking->id) }}'; },
                    onError: function() { alert('Pembayaran gagal. Silakan coba lagi.'); },
                    onClose: function() {}
                });
            };
        </script>
    @endpush
@endif