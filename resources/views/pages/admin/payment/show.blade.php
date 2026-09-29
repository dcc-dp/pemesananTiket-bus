@extends('layouts.app', ['title' => 'Detail Pembayaran ' . $data->order_id])

@section('content')
    <div class="main-content">
        <section class="section">
            <!-- PAGE HEADER: Modern Enterprise Header & Breadcrumb -->
            <div class="adm-page-header" style="margin-bottom: 18px;">
                <!-- Subtle Breadcrumb -->
                <div class="adm-breadcrumb" style="display: flex; align-items: center; gap: 6px; font-size: 11px; color: #64748b; margin-bottom: 10px;">
                    <a href="{{ route('admin.dashboard') }}" style="color: #64748b; text-decoration: none; font-weight: 500;">Home</a>
                    <span style="font-size: 8px; color: #94a3b8;"><i class="fas fa-chevron-right"></i></span>
                    <span style="color: #64748b;">Transaksi</span>
                    <span style="font-size: 8px; color: #94a3b8;"><i class="fas fa-chevron-right"></i></span>
                    <a href="{{ route('admin.payment.index') }}" style="color: #64748b; text-decoration: none; font-weight: 500;">Pembayaran</a>
                    <span style="font-size: 8px; color: #94a3b8;"><i class="fas fa-chevron-right"></i></span>
                    <span style="color: #0f172a; font-weight: 600;">{{ $data->order_id }}</span>
                </div>

                <!-- Page Title Row -->
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 38px; height: 38px; border-radius: 9px; background: #2563eb; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.22);">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <h1 style="font-size: 17px; font-weight: 700; color: #0f172a; margin: 0; line-height: 1.2; letter-spacing: -0.015em;">Detail Transaksi Pembayaran</h1>
                                <span style="font-family: monospace; font-size: 11.5px; font-weight: 700; color: #0f172a; background: #f1f5f9; padding: 2px 7px; border-radius: 5px; border: 1px solid #e2e8f0;">
                                    {{ $data->order_id }}
                                </span>
                            </div>
                            <p style="font-size: 11.5px; color: #64748b; margin: 2px 0 0 0; line-height: 1.3;">Informasi status pelunasan gateway dan relasi pesanan tiket</p>
                        </div>
                    </div>

                    <a href="{{ route('admin.payment.index') }}" class="btn" style="height: 34px; padding: 0 14px; background: #ffffff; color: #475569; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 11.5px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; text-decoration: none;">
                        <i class="fas fa-arrow-left" style="font-size: 10px;"></i>
                        <span>Kembali ke Daftar</span>
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- LEFT COLUMN: Informasi Pembayaran -->
                <div class="col-lg-6 col-12 mb-3 mb-lg-0">
                    <div class="card" style="border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); height: 100%; overflow: hidden;">
                        <div class="adm-form-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 10px 16px;">
                            <div class="adm-form-header-title" style="font-size: 12.5px; font-weight: 700;">
                                <div style="width: 24px; height: 24px; border-radius: 5px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 11px;">
                                    <i class="fas fa-receipt"></i>
                                </div>
                                <span>Informasi Pembayaran</span>
                            </div>
                        </div>

                        <div class="card-body" style="padding: 16px 18px;">
                            <div style="display: flex; flex-direction: column; gap: 10px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px dashed #f1f5f9; font-size: 11.5px;">
                                    <span style="color: #64748b;">Order ID</span>
                                    <span style="font-family: monospace; font-weight: 700; color: #0f172a;">{{ $data->order_id }}</span>
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px dashed #f1f5f9; font-size: 11.5px;">
                                    <span style="color: #64748b;">Transaction ID</span>
                                    <span style="font-family: monospace; color: #475569;">{{ $data->transaction_id ?? '-' }}</span>
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px dashed #f1f5f9; font-size: 11.5px;">
                                    <span style="color: #64748b;">Metode Pembayaran</span>
                                    <span style="font-size: 10.5px; font-weight: 600; text-transform: uppercase; background: #f8fafc; color: #334155; padding: 2px 6px; border-radius: 4px; border: 1px solid #cbd5e1;">
                                        {{ $data->payment_type ? ucfirst($data->payment_type) : '-' }}
                                    </span>
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px dashed #f1f5f9; font-size: 11.5px;">
                                    <span style="color: #64748b;">Jumlah Total</span>
                                    <span style="font-size: 13.5px; font-weight: 700; color: #2563eb;">
                                        Rp {{ number_format($data->gross_amount, 0, ',', '.') }}
                                    </span>
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px dashed #f1f5f9; font-size: 11.5px;">
                                    <span style="color: #64748b;">Transaction Status</span>
                                    <span style="font-weight: 600; color: #0f172a;">
                                        {{ $data->transaction_status ? ucfirst($data->transaction_status) : '-' }}
                                    </span>
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px dashed #f1f5f9; font-size: 11.5px;">
                                    <span style="color: #64748b;">Payment Status</span>
                                    @php
                                        $ps = $data->payment_status;
                                        $psBg = '#f1f5f9'; $psColor = '#475569'; $psBorder = '#cbd5e1';
                                        if ($ps == 'paid') {
                                            $psBg = '#f0fdf4'; $psColor = '#16a34a'; $psBorder = '#bbf7d0';
                                        } elseif ($ps == 'pending') {
                                            $psBg = '#fefce8'; $psColor = '#ca8a04'; $psBorder = '#fef08a';
                                        } else {
                                            $psBg = '#fef2f2'; $psColor = '#dc2626'; $psBorder = '#fecaca';
                                        }
                                    @endphp
                                    <span style="display: inline-flex; align-items: center; gap: 4px; padding: 2px 7px; border-radius: 9999px; font-size: 10.5px; font-weight: 600; background: {{ $psBg }}; color: {{ $psColor }}; border: 1px solid {{ $psBorder }};">
                                        <span style="width: 5px; height: 5px; border-radius: 50%; background: {{ $psColor }};"></span>
                                        {{ $data->payment_status_label }}
                                    </span>
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 11.5px;">
                                    <span style="color: #64748b;">Waktu Pelunasan</span>
                                    <span style="font-weight: 600; color: #0f172a;">
                                        {{ $data->paid_at ? $data->paid_at->format('d M Y H:i:s') : '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN: Informasi Booking -->
                <div class="col-lg-6 col-12">
                    <div class="card" style="border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); height: 100%; overflow: hidden;">
                        <div class="adm-form-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 10px 16px;">
                            <div class="adm-form-header-title" style="font-size: 12.5px; font-weight: 700;">
                                <div style="width: 24px; height: 24px; border-radius: 5px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 11px;">
                                    <i class="fas fa-ticket-alt"></i>
                                </div>
                                <span>Informasi Pesanan Tiket</span>
                            </div>
                        </div>

                        <div class="card-body" style="padding: 16px 18px;">
                            <div style="display: flex; flex-direction: column; gap: 10px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px dashed #f1f5f9; font-size: 11.5px;">
                                    <span style="color: #64748b;">Kode Booking</span>
                                    <a href="{{ route('admin.booking.show', $data->booking->id) }}" style="font-family: monospace; font-size: 11.5px; font-weight: 700; color: #2563eb; text-decoration: none;">
                                        {{ $data->booking->kode_booking }}
                                        <i class="fas fa-external-link-alt" style="font-size: 9.5px; margin-left: 3px;"></i>
                                    </a>
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px dashed #f1f5f9; font-size: 11.5px;">
                                    <span style="color: #64748b;">Customer</span>
                                    <span style="font-weight: 600; color: #0f172a;">{{ $data->booking->user->name }}</span>
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px dashed #f1f5f9; font-size: 11.5px;">
                                    <span style="color: #64748b;">Rute Perjalanan</span>
                                    <span style="font-weight: 600; color: #0f172a;">
                                        {{ $data->booking->jadwal->rute->terminalAsal->kota }} &rarr; {{ $data->booking->jadwal->rute->terminalTujuan->kota }}
                                    </span>
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px dashed #f1f5f9; font-size: 11.5px;">
                                    <span style="color: #64748b;">Jadwal Keberangkatan</span>
                                    <span style="font-weight: 600; color: #0f172a;">
                                        {{ $data->booking->jadwal->tanggal->format('d M Y') }} &middot; {{ $data->booking->jadwal->jam_berangkat->format('H:i') }} WIB
                                    </span>
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 11.5px;">
                                    <span style="color: #64748b;">Armada Bus</span>
                                    <span style="font-weight: 600; color: #0f172a;">
                                        {{ $data->booking->jadwal->bus->nama_bus }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection