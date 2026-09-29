@extends('layouts.app', ['title' => 'Detail Booking ' . $data->kode_booking])

@section('content')
    <div class="main-content">
        <section class="section">
            <!-- PAGE HEADER: Modern Enterprise Header & Breadcrumb -->
            <div class="adm-page-header" style="margin-bottom: 20px;">
                <!-- Subtle Breadcrumb -->
                <div class="adm-breadcrumb" style="display: flex; align-items: center; gap: 6px; font-size: 11.5px; color: #64748b; margin-bottom: 12px;">
                    <a href="{{ route('admin.dashboard') }}" style="color: #64748b; text-decoration: none; font-weight: 500;">Home</a>
                    <span style="font-size: 8px; color: #94a3b8;"><i class="fas fa-chevron-right"></i></span>
                    <span style="color: #64748b;">Transaksi</span>
                    <span style="font-size: 8px; color: #94a3b8;"><i class="fas fa-chevron-right"></i></span>
                    <a href="{{ route('admin.booking.index') }}" style="color: #64748b; text-decoration: none; font-weight: 500;">Booking</a>
                    <span style="font-size: 8px; color: #94a3b8;"><i class="fas fa-chevron-right"></i></span>
                    <span style="color: #0f172a; font-weight: 600;">{{ $data->kode_booking }}</span>
                </div>

                <!-- Page Title Row -->
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <div style="width: 42px; height: 42px; border-radius: 10px; background: #2563eb; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.22);">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                        <div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <h1 style="font-size: 19px; font-weight: 700; color: #0f172a; margin: 0; line-height: 1.2; letter-spacing: -0.015em;">Detail Booking</h1>
                                <span style="font-family: monospace; font-size: 13px; font-weight: 700; color: #1e40af; background: #eff6ff; padding: 2px 8px; border-radius: 6px; border: 1px solid #bfdbfe;">
                                    {{ $data->kode_booking }}
                                </span>
                            </div>
                            <p style="font-size: 12.5px; color: #64748b; margin: 3px 0 0 0; line-height: 1.3;">Rincian manifest penumpang, rute bus, dan status pelunasan transaksi</p>
                        </div>
                    </div>

                    <a href="{{ route('admin.booking.index') }}" class="adm-btn-cancel" style="height: 38px; padding: 0 16px; text-decoration: none; font-size: 12.5px;">
                        <i class="fas fa-arrow-left" style="font-size: 11px;"></i>
                        <span>Kembali ke Daftar</span>
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- LEFT COLUMN: Trip & Passenger Details -->
                <div class="col-lg-8 col-12">
                    <!-- Card: Informasi Perjalanan -->
                    <div class="card" style="border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); margin-bottom: 20px; overflow: hidden;">
                        <div class="adm-form-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                            <div class="adm-form-header-title">
                                <div style="width: 26px; height: 26px; border-radius: 6px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                                    <i class="fas fa-route"></i>
                                </div>
                                <span>Informasi Perjalanan</span>
                            </div>
                        </div>
                        <div class="card-body" style="padding: 22px;">
                            <!-- Route Journey Timeline -->
                            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 18px; margin-bottom: 20px;">
                                <div class="row align-items-center text-center">
                                    <div class="col-4">
                                        <div style="font-size: 20px; font-weight: 800; color: #0f172a; line-height: 1.2;">
                                            {{ $data->jadwal->jam_berangkat->format('H:i') }} <span style="font-size: 11px; font-weight: 500; color: #64748b;">WIB</span>
                                        </div>
                                        <div style="font-size: 13px; font-weight: 700; color: #2563eb; margin-top: 4px;">
                                            {{ $data->jadwal->rute->terminalAsal->nama_terminal }}
                                        </div>
                                        <div style="font-size: 11.5px; color: #64748b;">
                                            {{ $data->jadwal->rute->terminalAsal->kota }}
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div style="font-size: 11.5px; font-weight: 600; color: #475569; margin-bottom: 6px;">
                                            {{ $data->jadwal->tanggal->format('d M Y') }}
                                        </div>
                                        <div style="position: relative; display: flex; align-items: center; justify-content: center;">
                                            <div style="height: 2px; width: 100%; background: repeating-linear-gradient(to right, #93c5fd 0, #93c5fd 6px, transparent 6px, transparent 10px);"></div>
                                            <div style="position: absolute; width: 26px; height: 26px; border-radius: 50%; background: #2563eb; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 11px; box-shadow: 0 2px 4px rgba(37,99,235,0.25);">
                                                <i class="fas fa-bus"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div style="font-size: 20px; font-weight: 800; color: #0f172a; line-height: 1.2;">
                                            {{ $data->jadwal->jam_tiba ? $data->jadwal->jam_tiba->format('H:i') : '-' }} <span style="font-size: 11px; font-weight: 500; color: #64748b;">WIB</span>
                                        </div>
                                        <div style="font-size: 13px; font-weight: 700; color: #2563eb; margin-top: 4px;">
                                            {{ $data->jadwal->rute->terminalTujuan->nama_terminal }}
                                        </div>
                                        <div style="font-size: 11.5px; color: #64748b;">
                                            {{ $data->jadwal->rute->terminalTujuan->kota }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Meta Details Grid -->
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div style="display: flex; flex-direction: column; gap: 8px;">
                                        <div style="display: flex; justify-content: space-between; font-size: 12.5px; padding-bottom: 8px; border-bottom: 1px dashed #f1f5f9;">
                                            <span style="color: #64748b;">Armada Bus:</span>
                                            <span style="font-weight: 600; color: #0f172a;">{{ $data->jadwal->bus->nama_bus }} ({{ $data->jadwal->bus->nomor_polisi }})</span>
                                        </div>
                                        <div style="display: flex; justify-content: space-between; font-size: 12.5px; padding-bottom: 8px; border-bottom: 1px dashed #f1f5f9;">
                                            <span style="color: #64748b;">Operator PO:</span>
                                            <span style="font-weight: 600; color: #0f172a;">{{ $data->jadwal->bus->operator->nama_operator }}</span>
                                        </div>
                                        <div style="display: flex; justify-content: space-between; font-size: 12.5px;">
                                            <span style="color: #64748b;">Kelas Armada:</span>
                                            <span style="font-weight: 600; color: #0f172a; text-transform: uppercase;">{{ $data->jadwal->bus->kelas }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 mt-3 mt-md-0">
                                    <div style="display: flex; flex-direction: column; gap: 8px;">
                                        <div style="display: flex; justify-content: space-between; font-size: 12.5px; padding-bottom: 8px; border-bottom: 1px dashed #f1f5f9;">
                                            <span style="color: #64748b;">Nama Pemesan:</span>
                                            <span style="font-weight: 600; color: #0f172a;">{{ $data->user->name }}</span>
                                        </div>
                                        <div style="display: flex; justify-content: space-between; font-size: 12.5px; padding-bottom: 8px; border-bottom: 1px dashed #f1f5f9;">
                                            <span style="color: #64748b;">Waktu Pemesanan:</span>
                                            <span style="font-weight: 600; color: #0f172a;">{{ $data->tanggal_booking->format('d M Y H:i') }}</span>
                                        </div>
                                        @if ($data->paid_at)
                                            <div style="display: flex; justify-content: space-between; font-size: 12.5px;">
                                                <span style="color: #64748b;">Waktu Pelunasan:</span>
                                                <span style="font-weight: 600; color: #16a34a;">{{ $data->paid_at->format('d M Y H:i') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card: Data Penumpang -->
                    <div class="card" style="border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); overflow: hidden;">
                        <div class="adm-form-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                            <div class="adm-form-header-title">
                                <div style="width: 26px; height: 26px; border-radius: 6px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                                    <i class="fas fa-users"></i>
                                </div>
                                <span>Manifest Penumpang ({{ $data->bookingSeats->count() }} Orang)</span>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" style="width: 100%; border-collapse: separate; border-spacing: 0;">
                                <thead>
                                    <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                                        <th style="padding: 10px 14px; font-size: 10px; font-weight: 700; text-transform: uppercase; color: #64748b; border: none; width: 65px;">Kursi</th>
                                        <th style="padding: 10px 14px; font-size: 10px; font-weight: 700; text-transform: uppercase; color: #64748b; border: none;">Nama Lengkap</th>
                                        <th style="padding: 10px 14px; font-size: 10px; font-weight: 700; text-transform: uppercase; color: #64748b; border: none;">NIK KTP</th>
                                        <th style="padding: 10px 14px; font-size: 10px; font-weight: 700; text-transform: uppercase; color: #64748b; border: none;">No. Handphone</th>
                                        <th style="padding: 10px 14px; font-size: 10px; font-weight: 700; text-transform: uppercase; color: #64748b; border: none;">Gender</th>
                                        <th style="padding: 10px 14px; font-size: 10px; font-weight: 700; text-transform: uppercase; color: #64748b; border: none;">Tgl Lahir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->bookingSeats as $seat)
                                        <tr style="border-bottom: 1px solid #f1f5f9;">
                                            <td style="padding: 12px 14px; vertical-align: middle;">
                                                <span style="font-family: monospace; font-size: 11.5px; font-weight: 700; color: #1e40af; background: #eff6ff; padding: 3px 8px; border-radius: 6px; border: 1px solid #bfdbfe;">
                                                    {{ $seat->kursi->nomor_kursi }}
                                                </span>
                                            </td>
                                            <td style="padding: 12px 14px; vertical-align: middle; font-size: 12.5px; font-weight: 600; color: #0f172a;">
                                                {{ $seat->nama_penumpang }}
                                            </td>
                                            <td style="padding: 12px 14px; vertical-align: middle; font-size: 12px; color: #475569; font-family: monospace;">
                                                {{ $seat->nik ?: '-' }}
                                            </td>
                                            <td style="padding: 12px 14px; vertical-align: middle; font-size: 12px; color: #475569;">
                                                {{ $seat->no_hp ?: '-' }}
                                            </td>
                                            <td style="padding: 12px 14px; vertical-align: middle; font-size: 12px; color: #475569;">
                                                {{ $seat->jenis_kelamin == 'L' ? 'Laki-laki' : ($seat->jenis_kelamin == 'P' ? 'Perempuan' : $seat->jenis_kelamin) }}
                                            </td>
                                            <td style="padding: 12px 14px; vertical-align: middle; font-size: 12px; color: #475569;">
                                                {{ $seat->tanggal_lahir ? $seat->tanggal_lahir->format('d M Y') : '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN: Payment & Status Summary -->
                <div class="col-lg-4 col-12 mt-4 mt-lg-0">
                    <div class="card" style="border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); overflow: hidden;">
                        <div class="adm-form-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                            <div class="adm-form-header-title">
                                <div style="width: 26px; height: 26px; border-radius: 6px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                                    <i class="fas fa-money-check-alt"></i>
                                </div>
                                <span>Status Pemesanan</span>
                            </div>
                        </div>

                        <div class="card-body" style="padding: 20px;">
                            <!-- Status Badges -->
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                                <span style="font-size: 12.5px; color: #64748b;">Status Booking</span>
                                @php
                                    $sb = $data->status_booking;
                                    $sbBg = '#f1f5f9'; $sbColor = '#475569'; $sbBorder = '#cbd5e1';
                                    if (in_array($sb, ['confirmed', 'completed'])) {
                                        $sbBg = '#f0fdf4'; $sbColor = '#16a34a'; $sbBorder = '#bbf7d0';
                                    } elseif ($sb == 'pending') {
                                        $sbBg = '#fefce8'; $sbColor = '#ca8a04'; $sbBorder = '#fef08a';
                                    } elseif (in_array($sb, ['cancelled', 'expired'])) {
                                        $sbBg = '#fef2f2'; $sbColor = '#dc2626'; $sbBorder = '#fecaca';
                                    }
                                @endphp
                                <span style="display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: 9999px; font-size: 11px; font-weight: 600; background: {{ $sbBg }}; color: {{ $sbColor }}; border: 1px solid {{ $sbBorder }};">
                                    <span style="width: 5px; height: 5px; border-radius: 50%; background: {{ $sbColor }};"></span>
                                    {{ $data->status_booking_label }}
                                </span>
                            </div>

                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                                <span style="font-size: 12.5px; color: #64748b;">Status Bayar</span>
                                @php
                                    $sp = $data->status_pembayaran;
                                    $spBg = '#f1f5f9'; $spColor = '#475569'; $spBorder = '#cbd5e1';
                                    if ($sp == 'paid') {
                                        $spBg = '#f0fdf4'; $spColor = '#16a34a'; $spBorder = '#bbf7d0';
                                    } elseif ($sp == 'pending') {
                                        $spBg = '#fefce8'; $spColor = '#ca8a04'; $spBorder = '#fef08a';
                                    } else {
                                        $spBg = '#fef2f2'; $spColor = '#dc2626'; $spBorder = '#fecaca';
                                    }
                                @endphp
                                <span style="display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: 9999px; font-size: 11px; font-weight: 600; background: {{ $spBg }}; color: {{ $spColor }}; border: 1px solid {{ $spBorder }};">
                                    <span style="width: 5px; height: 5px; border-radius: 50%; background: {{ $spColor }};"></span>
                                    {{ $data->status_pembayaran_label }}
                                </span>
                            </div>

                            @if ($data->payment)
                                <div style="background: #f8fafc; border-radius: 8px; padding: 12px; margin-bottom: 14px; border: 1px solid #e2e8f0;">
                                    <div style="display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 6px;">
                                        <span style="color: #64748b;">Order ID:</span>
                                        <span style="font-family: monospace; font-weight: 600; color: #0f172a;">{{ $data->payment->order_id }}</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; font-size: 12px;">
                                        <span style="color: #64748b;">Metode:</span>
                                        <span style="font-weight: 600; color: #0f172a; text-transform: uppercase;">{{ $data->payment->payment_type ?: '-' }}</span>
                                    </div>
                                </div>
                            @endif

                            <div style="border-top: 1px dashed #e2e8f0; padding-top: 14px; margin-bottom: 18px;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-size: 13px; font-weight: 600; color: #475569;">Total Biaya</span>
                                    <span style="font-size: 18px; font-weight: 800; color: #2563eb;">
                                        Rp {{ number_format($data->total_harga, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Actions for this Booking -->
                            <div style="display: flex; flex-direction: column; gap: 8px;">
                                @if ($data->status_booking == 'pending' && $data->status_pembayaran == 'pending')
                                    <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 12px; margin-bottom: 6px;">
                                        <div style="font-size: 12px; font-weight: 600; color: #1e40af; margin-bottom: 8px;">
                                            <i class="fas fa-cash-register" style="margin-right: 4px;"></i> Konfirmasi Pembayaran Manual
                                        </div>
                                        <form method="POST" action="{{ route('admin.booking.confirm-payment', $data->id) }}" style="margin: 0;">
                                            @csrf
                                            <div style="margin-bottom: 8px;">
                                                <input type="text" name="payment_method" class="adm-input" placeholder="Metode (cash / transfer)" required style="height: 36px; font-size: 12px;">
                                            </div>
                                            <button type="submit" class="adm-btn-submit" style="width: 100%; height: 36px; justify-content: center; background: #16a34a; font-size: 12px;" onclick="return confirm('Konfirmasi bahwa pembayaran tiket ini telah diterima?');">
                                                <i class="fas fa-check-circle" style="font-size: 11px;"></i>
                                                <span>Konfirmasi Pembayaran</span>
                                            </button>
                                        </form>
                                    </div>
                                @endif

                                @if (in_array($data->status_booking, ['pending', 'confirmed']))
                                    <form method="POST" action="{{ route('admin.booking.status', $data->id) }}" style="margin: 0;">
                                        @csrf
                                        <input type="hidden" name="status_booking" value="completed">
                                        <button type="submit" class="adm-btn-submit" style="width: 100%; height: 38px; justify-content: center; font-size: 12.5px;" onclick="return confirm('Tandai booking ini sebagai SELESAI?');">
                                            <i class="fas fa-check" style="font-size: 11px;"></i>
                                            <span>Tandai Perjalanan Selesai</span>
                                        </button>
                                    </form>
                                @endif

                                @if (!in_array($data->status_booking, ['cancelled', 'expired']))
                                    <form method="POST" action="{{ route('admin.booking.cancel', $data->id) }}" style="margin: 0;">
                                        @csrf
                                        <button type="submit" class="adm-btn-cancel" style="width: 100%; height: 38px; justify-content: center; font-size: 12.5px; color: #dc2626; border-color: #fecaca; background: #fef2f2;" onclick="return confirm('Batalkan booking ini? Kursi yang telah dipesan akan dilepas kembali.');">
                                            <i class="fas fa-ban" style="font-size: 11px;"></i>
                                            <span>Batalkan Pesanan</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection