@extends('layouts.app', ['title' => 'Laporan Transaksi'])

@section('content')
    <div class="main-content">
        <section class="section">
            <!-- PAGE HEADER: Modern Enterprise Header & Breadcrumb -->
            <div class="adm-page-header" style="margin-bottom: 20px;">
                <!-- Subtle Breadcrumb -->
                <div class="adm-breadcrumb" style="display: flex; align-items: center; gap: 6px; font-size: 11.5px; color: #64748b; margin-bottom: 12px;">
                    <a href="{{ route('admin.dashboard') }}" style="color: #64748b; text-decoration: none; font-weight: 500;">Home</a>
                    <span style="font-size: 8px; color: #94a3b8;"><i class="fas fa-chevron-right"></i></span>
                    <span style="color: #64748b;">Laporan</span>
                    <span style="font-size: 8px; color: #94a3b8;"><i class="fas fa-chevron-right"></i></span>
                    <span style="color: #0f172a; font-weight: 600;">Transaksi</span>
                </div>

                <!-- Page Title Row -->
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <div style="width: 42px; height: 42px; border-radius: 10px; background: #2563eb; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.22);">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div>
                            <h1 style="font-size: 19px; font-weight: 700; color: #0f172a; margin: 0; line-height: 1.2; letter-spacing: -0.015em;">Laporan Transaksi & Pendapatan</h1>
                            <p style="font-size: 12.5px; color: #64748b; margin: 3px 0 0 0; line-height: 1.3;">Rekapitulasi penjualan tiket bus, okupansi rute, dan total omset periode tertentu</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FILTER CARD CONTAINER -->
            <div class="card" style="border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); margin-bottom: 20px; overflow: hidden;">
                <div class="adm-form-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <div class="adm-form-header-title">
                        <div style="width: 26px; height: 26px; border-radius: 6px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                            <i class="fas fa-filter"></i>
                        </div>
                        <span>Filter Parameter Laporan</span>
                    </div>
                </div>

                <div class="card-body" style="padding: 20px;">
                    <form action="{{ route('admin.report.index') }}" method="GET" style="margin: 0;">
                        <div class="row" style="margin-left: -8px; margin-right: -8px;">
                            <!-- Dari Tanggal -->
                            <div class="col-md-3 col-6" style="padding-left: 8px; padding-right: 8px; margin-bottom: 14px;">
                                <label class="adm-form-label" style="margin-bottom: 6px;">Dari Tanggal</label>
                                <input type="date" name="tanggal_mulai" class="adm-input" value="{{ $filter['tanggal_mulai'] ?? '' }}" style="height: 38px;">
                            </div>

                            <!-- Sampai Tanggal -->
                            <div class="col-md-3 col-6" style="padding-left: 8px; padding-right: 8px; margin-bottom: 14px;">
                                <label class="adm-form-label" style="margin-bottom: 6px;">Sampai Tanggal</label>
                                <input type="date" name="tanggal_akhir" class="adm-input" value="{{ $filter['tanggal_akhir'] ?? '' }}" style="height: 38px;">
                            </div>

                            <!-- Operator -->
                            <div class="col-md-3 col-6" style="padding-left: 8px; padding-right: 8px; margin-bottom: 14px;">
                                <label class="adm-form-label" style="margin-bottom: 6px;">Operator Bus</label>
                                <select name="operator_id" class="adm-select" style="height: 38px;">
                                    <option value="">Semua Operator</option>
                                    @foreach ($operators as $operator)
                                        <option value="{{ $operator->id }}" {{ ($filter['operator_id'] ?? '') == $operator->id ? 'selected' : '' }}>
                                            {{ $operator->nama_operator }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Bus -->
                            <div class="col-md-3 col-6" style="padding-left: 8px; padding-right: 8px; margin-bottom: 14px;">
                                <label class="adm-form-label" style="margin-bottom: 6px;">Armada Bus</label>
                                <select name="bus_id" class="adm-select" style="height: 38px;">
                                    <option value="">Semua Armada</option>
                                    @foreach ($buses as $b)
                                        <option value="{{ $b->id_bus }}" {{ ($filter['bus_id'] ?? '') == $b->id_bus ? 'selected' : '' }}>
                                            {{ $b->nama_bus }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Terminal Asal -->
                            <div class="col-md-3 col-6" style="padding-left: 8px; padding-right: 8px; margin-bottom: 14px;">
                                <label class="adm-form-label" style="margin-bottom: 6px;">Terminal Keberangkatan</label>
                                <select name="terminal_asal" class="adm-select" style="height: 38px;">
                                    <option value="">Semua Terminal</option>
                                    @foreach ($terminals as $terminal)
                                        <option value="{{ $terminal->id_terminal }}" {{ ($filter['terminal_asal'] ?? '') == $terminal->id_terminal ? 'selected' : '' }}>
                                            {{ $terminal->kota }} - {{ $terminal->nama_terminal }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Terminal Tujuan -->
                            <div class="col-md-3 col-6" style="padding-left: 8px; padding-right: 8px; margin-bottom: 14px;">
                                <label class="adm-form-label" style="margin-bottom: 6px;">Terminal Kedatangan</label>
                                <select name="terminal_tujuan" class="adm-select" style="height: 38px;">
                                    <option value="">Semua Terminal</option>
                                    @foreach ($terminals as $terminal)
                                        <option value="{{ $terminal->id_terminal }}" {{ ($filter['terminal_tujuan'] ?? '') == $terminal->id_terminal ? 'selected' : '' }}>
                                            {{ $terminal->kota }} - {{ $terminal->nama_terminal }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status Booking -->
                            <div class="col-md-3 col-6" style="padding-left: 8px; padding-right: 8px; margin-bottom: 14px;">
                                <label class="adm-form-label" style="margin-bottom: 6px;">Status Pemesanan</label>
                                <select name="status_booking" class="adm-select" style="height: 38px;">
                                    <option value="">Semua Status</option>
                                    @foreach (['pending', 'confirmed', 'completed', 'cancelled', 'expired'] as $status)
                                        <option value="{{ $status }}" {{ ($filter['status_booking'] ?? '') == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status Pembayaran -->
                            <div class="col-md-3 col-6" style="padding-left: 8px; padding-right: 8px; margin-bottom: 14px;">
                                <label class="adm-form-label" style="margin-bottom: 6px;">Status Pembayaran</label>
                                <select name="status_pembayaran" class="adm-select" style="height: 38px;">
                                    <option value="">Semua Status</option>
                                    @foreach (['paid', 'pending', 'failed'] as $status)
                                        <option value="{{ $status }}" {{ ($filter['status_pembayaran'] ?? '') == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 6px; padding-top: 14px; border-top: 1px dashed #e2e8f0;">
                            <button type="submit" class="adm-btn-submit" style="height: 38px; padding: 0 16px;">
                                <i class="fas fa-filter" style="font-size: 11px;"></i>
                                <span>Tampilkan Laporan</span>
                            </button>
                            <button type="submit" name="cetak" value="1" class="adm-btn-submit" style="height: 38px; padding: 0 16px; background: #16a34a; box-shadow: 0 1px 2px rgba(22,163,74,0.2);">
                                <i class="fas fa-print" style="font-size: 11px;"></i>
                                <span>Cetak / Ekspor PDF</span>
                            </button>
                            <a href="{{ route('admin.report.index') }}" class="adm-btn-cancel" style="height: 38px; padding: 0 14px; text-decoration: none;">
                                <span>Reset Filter</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- METRIC STATISTIC CARDS -->
            <div class="row" style="margin-bottom: 20px;">
                <!-- Total Transaksi -->
                <div class="col-lg-4 col-md-6 col-12 mb-3 mb-lg-0">
                    <div class="card" style="border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); padding: 18px;">
                        <div style="display: flex; align-items: center; gap: 14px;">
                            <div style="width: 44px; height: 44px; border-radius: 10px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                                <i class="fas fa-file-invoice"></i>
                            </div>
                            <div>
                                <div style="font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">
                                    Total Transaksi
                                </div>
                                <div style="font-size: 22px; font-weight: 800; color: #0f172a; line-height: 1.2; margin-top: 2px;">
                                    {{ number_format($totalTransaksi, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Tiket Terjual -->
                <div class="col-lg-4 col-md-6 col-12 mb-3 mb-lg-0">
                    <div class="card" style="border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); padding: 18px;">
                        <div style="display: flex; align-items: center; gap: 14px;">
                            <div style="width: 44px; height: 44px; border-radius: 10px; background: #f0fdf4; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                            <div>
                                <div style="font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">
                                    Total Tiket Terjual
                                </div>
                                <div style="font-size: 22px; font-weight: 800; color: #0f172a; line-height: 1.2; margin-top: 2px;">
                                    {{ number_format($totalTiket, 0, ',', '.') }} Kursi
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Pendapatan -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="card" style="border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); padding: 18px;">
                        <div style="display: flex; align-items: center; gap: 14px;">
                            <div style="width: 44px; height: 44px; border-radius: 10px; background: #faf5ff; color: #7c3aed; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div>
                                <div style="font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">
                                    Total Pendapatan
                                </div>
                                <div style="font-size: 22px; font-weight: 800; color: #0f172a; line-height: 1.2; margin-top: 2px;">
                                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DATA TABLE CARD -->
            <div class="card" style="border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); overflow: hidden;">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" style="width: 100%; border-collapse: separate; border-spacing: 0;">
                        <thead>
                            <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                                <th style="padding: 12px 14px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none;">Kode</th>
                                <th style="padding: 12px 14px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none;">Tanggal</th>
                                <th style="padding: 12px 14px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none;">Customer</th>
                                <th style="padding: 12px 14px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none;">Rute</th>
                                <th style="padding: 12px 14px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none;">Armada Bus</th>
                                <th style="padding: 12px 14px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none;">Operator</th>
                                <th style="padding: 12px 14px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none;">Total</th>
                                <th style="padding: 12px 14px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none;">Status Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($datas as $data)
                                <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;">
                                    <!-- Kode Booking -->
                                    <td style="padding: 12px 14px; vertical-align: middle;">
                                        <a href="{{ route('admin.booking.show', $data->id ?? '') }}" style="font-family: monospace; font-size: 12px; font-weight: 700; color: #1e40af; background: #eff6ff; padding: 3px 8px; border-radius: 6px; border: 1px solid #bfdbfe; text-decoration: none;">
                                            {{ $data->kode_booking }}
                                        </a>
                                    </td>

                                    <!-- Tanggal -->
                                    <td style="padding: 12px 14px; vertical-align: middle;">
                                        <div style="font-size: 12px; color: #0f172a; font-weight: 500;">
                                            {{ \Carbon\Carbon::parse($data->tanggal)->format('d M Y') }}
                                        </div>
                                        <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                                            <i class="far fa-clock" style="font-size: 10px; margin-right: 3px;"></i>{{ \Carbon\Carbon::parse($data->jam_berangkat)->format('H:i') }} WIB
                                        </div>
                                    </td>

                                    <!-- Customer -->
                                    <td style="padding: 12px 14px; vertical-align: middle; font-size: 12.5px; font-weight: 600; color: #0f172a;">
                                        {{ $data->customer }}
                                    </td>

                                    <!-- Rute -->
                                    <td style="padding: 12px 14px; vertical-align: middle;">
                                        <div style="font-size: 12px; font-weight: 600; color: #0f172a; display: flex; align-items: center; gap: 5px;">
                                            <span>{{ $data->kota_asal }}</span>
                                            <i class="fas fa-arrow-right" style="font-size: 9px; color: #94a3b8;"></i>
                                            <span>{{ $data->kota_tujuan }}</span>
                                        </div>
                                    </td>

                                    <!-- Bus -->
                                    <td style="padding: 12px 14px; vertical-align: middle; font-size: 12.5px; color: #334155;">
                                        {{ $data->nama_bus }}
                                    </td>

                                    <!-- Operator -->
                                    <td style="padding: 12px 14px; vertical-align: middle; font-size: 12.5px; font-weight: 500; color: #334155;">
                                        {{ $data->nama_operator }}
                                    </td>

                                    <!-- Total -->
                                    <td style="padding: 12px 14px; vertical-align: middle;">
                                        <span style="font-size: 12.5px; font-weight: 700; color: #0f172a;">
                                            Rp {{ number_format($data->total_harga, 0, ',', '.') }}
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
                                            {{ ucfirst($data->status_pembayaran) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" style="padding: 48px 16px; text-align: center;">
                                        <div style="width: 52px; height: 52px; border-radius: 12px; background: #f1f5f9; color: #94a3b8; display: flex; align-items: center; justify-content: center; font-size: 22px; margin: 0 auto 12px;">
                                            <i class="fas fa-chart-line"></i>
                                        </div>
                                        <div style="font-size: 14px; font-weight: 600; color: #1e293b; margin-bottom: 4px;">Tidak ada data laporan</div>
                                        <div style="font-size: 12px; color: #64748b;">
                                            Tidak ada data transaksi yang sesuai dengan parameter filter yang dipilih
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
                            Menampilkan <span style="font-weight: 600; color: #0f172a;">{{ $datas->firstItem() }}</span> sampai <span style="font-weight: 600; color: #0f172a;">{{ $datas->lastItem() }}</span> dari <span style="font-weight: 600; color: #0f172a;">{{ $datas->total() }}</span> rekaman transaksi
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