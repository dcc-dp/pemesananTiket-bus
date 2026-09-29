@extends('layouts.app', ['title' => 'Data Pemesanan Tiket'])

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
                    <span style="color: #0f172a; font-weight: 600;">Booking</span>
                </div>

                <!-- Page Title Row -->
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <div style="width: 42px; height: 42px; border-radius: 10px; background: #2563eb; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.22);">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                        <div>
                            <h1 style="font-size: 19px; font-weight: 700; color: #0f172a; margin: 0; line-height: 1.2; letter-spacing: -0.015em;">Data Pemesanan Tiket</h1>
                            <p style="font-size: 12.5px; color: #64748b; margin: 3px 0 0 0; line-height: 1.3;">Kelola seluruh riwayat pemesanan tiket, status pembayaran, dan manifest penumpang</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FILTER CARD CONTAINER -->
            <div class="card" style="border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); margin-bottom: 16px;">
                <div class="card-body" style="padding: 14px 18px;">
                    <form action="{{ route('admin.booking.index') }}" method="GET" style="margin: 0;">
                        <div class="row align-items-center" style="margin-left: -6px; margin-right: -6px;">
                            <div class="col-md-4 col-12 mb-2 mb-md-0" style="padding-left: 6px; padding-right: 6px;">
                                <div style="position: relative;">
                                    <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); font-size: 12px; color: #94a3b8;"></i>
                                    <input type="text" name="kode_booking" class="adm-input" placeholder="Cari Kode Booking..."
                                        value="{{ $filter['kode_booking'] ?? '' }}" style="padding-left: 34px; height: 38px;">
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2 mb-md-0" style="padding-left: 6px; padding-right: 6px;">
                                <select name="status_booking" class="adm-select" style="height: 38px;">
                                    <option value="">Semua Status Booking</option>
                                    @foreach (['pending', 'confirmed', 'completed', 'cancelled', 'expired'] as $status)
                                        <option value="{{ $status }}" {{ ($filter['status_booking'] ?? '') == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-6 mb-2 mb-md-0" style="padding-left: 6px; padding-right: 6px;">
                                <select name="status_pembayaran" class="adm-select" style="height: 38px;">
                                    <option value="">Semua Status Bayar</option>
                                    @foreach (['paid', 'pending', 'failed', 'expired'] as $status)
                                        <option value="{{ $status }}" {{ ($filter['status_pembayaran'] ?? '') == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 col-12 d-flex gap-2" style="padding-left: 6px; padding-right: 6px; gap: 8px;">
                                <button type="submit" class="adm-btn-submit" style="height: 38px; padding: 0 14px; flex: 1; justify-content: center;">
                                    <i class="fas fa-filter" style="font-size: 11px;"></i>
                                    <span>Filter</span>
                                </button>
                                @if(!empty($filter['kode_booking']) || !empty($filter['status_booking']) || !empty($filter['status_pembayaran']))
                                    <a href="{{ route('admin.booking.index') }}" class="adm-btn-cancel" style="height: 38px; padding: 0 12px; text-decoration: none; justify-content: center;" title="Reset Filter">
                                        <i class="fas fa-times" style="font-size: 11px;"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- DATA TABLE CARD -->
            <div class="card" style="border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); overflow: hidden;">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" style="width: 100%; border-collapse: separate; border-spacing: 0;">
                        <thead>
                            <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                                <th style="padding: 12px 14px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none;">Kode</th>
                                <th style="padding: 12px 14px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none;">Customer</th>
                                <th style="padding: 12px 14px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none;">Rute Perjalanan</th>
                                <th style="padding: 12px 14px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none;">Jadwal</th>
                                <th style="padding: 12px 14px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none;">Kursi</th>
                                <th style="padding: 12px 14px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none;">Total</th>
                                <th style="padding: 12px 14px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none;">Status Booking</th>
                                <th style="padding: 12px 14px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none;">Status Bayar</th>
                                <th style="padding: 12px 14px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none; text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($datas as $data)
                                <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;">
                                    <!-- Kode Booking -->
                                    <td style="padding: 12px 14px; vertical-align: middle;">
                                        <span style="font-family: monospace; font-size: 12px; font-weight: 700; color: #1e40af; background: #eff6ff; padding: 3px 8px; border-radius: 6px; border: 1px solid #bfdbfe;">
                                            {{ $data->kode_booking }}
                                        </span>
                                    </td>

                                    <!-- Customer -->
                                    <td style="padding: 12px 14px; vertical-align: middle;">
                                        <div style="font-size: 12.5px; font-weight: 600; color: #0f172a; line-height: 1.2;">
                                            {{ $data->user->name }}
                                        </div>
                                        <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                                            {{ $data->user->phone ?? $data->user->email }}
                                        </div>
                                    </td>

                                    <!-- Rute -->
                                    <td style="padding: 12px 14px; vertical-align: middle;">
                                        <div style="font-size: 12px; font-weight: 600; color: #0f172a; display: flex; align-items: center; gap: 5px;">
                                            <span>{{ $data->jadwal->rute->terminalAsal->kota }}</span>
                                            <i class="fas fa-arrow-right" style="font-size: 9px; color: #94a3b8;"></i>
                                            <span>{{ $data->jadwal->rute->terminalTujuan->kota }}</span>
                                        </div>
                                        <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                                            {{ $data->jadwal->bus->nama_bus }}
                                        </div>
                                    </td>

                                    <!-- Jadwal -->
                                    <td style="padding: 12px 14px; vertical-align: middle;">
                                        <div style="font-size: 12px; color: #0f172a; font-weight: 500;">
                                            {{ $data->jadwal->tanggal->format('d M Y') }}
                                        </div>
                                        <div style="font-size: 11px; color: #2563eb; font-weight: 600; margin-top: 2px;">
                                            <i class="far fa-clock" style="font-size: 10px; margin-right: 3px;"></i>{{ $data->jadwal->jam_berangkat->format('H:i') }} WIB
                                        </div>
                                    </td>

                                    <!-- Kursi -->
                                    <td style="padding: 12px 14px; vertical-align: middle;">
                                        <div style="display: flex; flex-wrap: wrap; gap: 4px;">
                                            @foreach($data->bookingSeats as $s)
                                                <span style="font-size: 11px; font-weight: 600; background: #f8fafc; color: #334155; padding: 2px 6px; border-radius: 4px; border: 1px solid #cbd5e1;">
                                                    {{ $s->kursi->nomor_kursi }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>

                                    <!-- Total -->
                                    <td style="padding: 12px 14px; vertical-align: middle;">
                                        <span style="font-size: 12.5px; font-weight: 700; color: #0f172a;">
                                            Rp {{ number_format($data->total_harga, 0, ',', '.') }}
                                        </span>
                                    </td>

                                    <!-- Status Booking -->
                                    <td style="padding: 12px 14px; vertical-align: middle;">
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
                                        <span style="display: inline-flex; align-items: center; gap: 4px; padding: 3px 8px; border-radius: 9999px; font-size: 11px; font-weight: 600; background: {{ $sbBg }}; color: {{ $sbColor }}; border: 1px solid {{ $sbBorder }};">
                                            <span style="width: 5px; height: 5px; border-radius: 50%; background: {{ $sbColor }};"></span>
                                            {{ $data->status_booking_label }}
                                        </span>
                                    </td>

                                    <!-- Status Bayar -->
                                    <td style="padding: 12px 14px; vertical-align: middle;">
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
                                        <span style="display: inline-flex; align-items: center; gap: 4px; padding: 3px 8px; border-radius: 9999px; font-size: 11px; font-weight: 600; background: {{ $spBg }}; color: {{ $spColor }}; border: 1px solid {{ $spBorder }};">
                                            <span style="width: 5px; height: 5px; border-radius: 50%; background: {{ $spColor }};"></span>
                                            {{ $data->status_pembayaran_label }}
                                        </span>
                                    </td>

                                    <!-- Action -->
                                    <td style="padding: 12px 14px; vertical-align: middle; text-align: right;">
                                        <a href="{{ route('admin.booking.show', $data->id) }}" class="adm-btn-submit" style="display: inline-flex; height: 30px; padding: 0 10px; font-size: 11.5px; border-radius: 6px; text-decoration: none;">
                                            <i class="fas fa-eye" style="font-size: 10px;"></i>
                                            <span>Detail</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" style="padding: 48px 16px; text-align: center;">
                                        <div style="width: 52px; height: 52px; border-radius: 12px; background: #f1f5f9; color: #94a3b8; display: flex; align-items: center; justify-content: center; font-size: 22px; margin: 0 auto 12px;">
                                            <i class="fas fa-receipt"></i>
                                        </div>
                                        <div style="font-size: 14px; font-weight: 600; color: #1e293b; margin-bottom: 4px;">Tidak ada data booking</div>
                                        <div style="font-size: 12px; color: #64748b;">
                                            Belum ada transaksi pemesanan tiket yang sesuai dengan kriteria pencarian
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($datas->hasPages())
                    <div style="padding: 14px 18px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; background: #f8fafc;">
                        <div style="font-size: 12px; color: #64748b;">
                            Menampilkan <span style="font-weight: 600; color: #0f172a;">{{ $datas->firstItem() }}</span> sampai <span style="font-weight: 600; color: #0f172a;">{{ $datas->lastItem() }}</span> dari <span style="font-weight: 600; color: #0f172a;">{{ $datas->total() }}</span> pemesanan
                        </div>
                        <div>
                            {{ $datas->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection