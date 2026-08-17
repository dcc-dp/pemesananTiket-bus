@extends('layouts.landing.app', ['menu' => 'tiket'])

@push('styles')
<style>
    @media print {
        body * { visibility: hidden; }
        #ticketPrint, #ticketPrint * { visibility: visible; }
        #ticketPrint { position: absolute; left: 0; top: 0; width: 100%; }
        .no-print { display: none !important; }
    }
    .ticket-perforation {
        border-left: 2px dashed #c0c9d6;
    }
    @media (max-width: 767.98px) {
        .ticket-perforation { border-left: none; border-top: 2px dashed #c0c9d6; margin-top: 1rem; padding-top: 1rem; }
    }
</style>
@endpush

@section('content')
    <div class="no-print" style="background: linear-gradient(135deg, #0B1F3A 0%, #123E73 50%, #1E5AA8 100%); padding: 40px 0; margin-bottom: 30px;">
        <div class="container d-flex align-items-center justify-content-between">
            <div>
                <h5 class="text-white font-weight-bold mb-0"><i class="fas fa-ticket-alt"></i> E-Tiket</h5>
                <small class="text-white-50">Kode Booking: <strong class="text-white">{{ $ticket['kode_booking'] }}</strong></small>
            </div>
            <button onclick="window.print()" class="btn btn-light font-weight-bold">
                <i class="fas fa-print"></i> Cetak Tiket
            </button>
        </div>
    </div>

    <div class="container" style="margin-bottom: 60px;">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div id="ticketPrint" class="card border-0 shadow" style="border-radius: 16px; overflow: hidden;">
                    {{-- header tiket --}}
                    <div style="background: linear-gradient(135deg, #0B1F3A, #1E5AA8); padding: 20px 30px; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <span style="color: #fff; font-size: 1.4rem; font-weight: 800;"><i class="fas fa-bus"></i> BusTicket</span>
                            <div style="color: rgba(255,255,255,0.8); font-size: 0.8rem; margin-top: 4px;">E-Tiket Digital &middot; {{ $ticket['operator'] }}</div>
                        </div>
                        <div style="color: #fff; font-weight: 700; font-size: 1.1rem; text-align: right;">
                            <i class="fas fa-check-circle"></i> PAID
                            <div style="font-size: 0.7rem; font-weight: 400; color: rgba(255,255,255,0.8);">Tiket Sah</div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-8">
                                {{-- rute --}}
                                <div class="d-flex align-items-center">
                                    <div class="text-center">
                                        <h4 class="font-weight-bold mb-0" style="color: #0B1F3A;">{{ \Carbon\Carbon::parse($ticket['jam_berangkat'])->format('H:i') }}</h4>
                                        <small class="text-muted">{{ $ticket['asal'] }}</small>
                                    </div>
                                    <div class="mx-3 text-center flex-grow-1">
                                        <div class="small text-muted">{{ $ticket['tanggal']->format('d M Y') }}</div>
                                        <div style="border-top: 2px solid #1E5AA8; position: relative; margin: 8px 0;">
                                            <i class="fas fa-circle" style="position: absolute; top: -6px; left: 0; color: #1E5AA8; font-size: 0.5rem;"></i>
                                            <i class="fas fa-bus" style="position: absolute; top: -9px; right: 0; color: #1E5AA8; font-size: 0.9rem;"></i>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <h4 class="font-weight-bold mb-0" style="color: #0B1F3A;">{{ \Carbon\Carbon::parse($ticket['jam_tiba'])->format('H:i') }}</h4>
                                        <small class="text-muted">{{ $ticket['tujuan'] }}</small>
                                    </div>
                                </div>

                                <hr>

                                {{-- detail bus --}}
                                <div class="row small">
                                    <div class="col-6 mb-2">
                                        <div class="text-muted">Bus</div>
                                        <div class="font-weight-bold" style="color: #0B1F3A;">{{ $ticket['bus'] }} ({{ $ticket['nomor_polisi'] }})</div>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <div class="text-muted">Kelas</div>
                                        <div class="font-weight-bold" style="color: #0B1F3A;">{{ ucfirst($ticket['kelas']) }}</div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="text-muted">Fasilitas</div>
                                        <div class="font-weight-bold" style="color: #0B1F3A;">{{ $ticket['fasilitas'] ?: '-' }}</div>
                                    </div>
                                </div>

                                {{-- penumpang --}}
                                <div class="table-responsive">
                                <table class="table table-sm table-bordered mt-2 mb-0">
                                    <thead style="background: #f8fafc;">
                                        <tr>
                                            <th class="small">No</th>
                                            <th class="small">Penumpang</th>
                                            <th class="small">NIK</th>
                                            <th class="small">Kursi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ticket['booking_seats'] as $i => $p)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td class="font-weight-bold">{{ $p['nama_penumpang'] }}</td>
                                                <td>{{ $p['nik'] }}</td>
                                                <td class="font-weight-bold">{{ $p['kursi'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                            </div>

                            {{-- qr --}}
                            <div class="col-md-4 ticket-perforation text-center">
                                <img src="{{ $qr }}" alt="QR Code" style="width: 160px; height: 160px;">
                                <div class="font-weight-bold mt-2" style="color: #0B1F3A;">{{ $ticket['kode_booking'] }}</div>
                                <div class="small text-muted">Scan untuk verifikasi tiket</div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted small">Total Dibayar</span>
                                    <span class="font-weight-bold" style="color: #1E5AA8;">Rp {{ number_format($ticket['total_harga'], 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mt-1">
                                    <span class="text-muted small">Pemesanan</span>
                                    <span class="small font-weight-bold">{{ $ticket['tanggal_booking']->format('d M Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="background: #f8fafc; padding: 10px 30px; border-top: 1px solid #e9ecef;">
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i> Simpan tiket ini &middot; Tunjukkan e-tiket (cetak/scan QR) kepada petugas saat naik bus. Tiket berlaku sesuai jadwal pada tiket.
                        </small>
                    </div>
                </div>

                <div class="no-print text-center mt-3">
                    <a href="{{ route('customer.booking.detail', $booking->id) }}" class="btn btn-outline-primary font-weight-bold">
                        <i class="fas fa-arrow-left"></i> Kembali ke Detail
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection