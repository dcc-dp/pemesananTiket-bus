@extends('layouts.app', ['title' => 'Data Pembayaran'])

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
                    <span style="color: #0f172a; font-weight: 600;">Pembayaran</span>
                </div>

                <!-- Page Title Row -->
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <div style="width: 42px; height: 42px; border-radius: 10px; background: #2563eb; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.22);">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <div>
                            <h1 style="font-size: 19px; font-weight: 700; color: #0f172a; margin: 0; line-height: 1.2; letter-spacing: -0.015em;">Data Pembayaran</h1>
                            <p style="font-size: 12.5px; color: #64748b; margin: 3px 0 0 0; line-height: 1.3;">Log transaksi pembayaran, status gateway Midtrans, dan verifikasi pelunasan tiket</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FILTER CARD CONTAINER -->
            <div class="card" style="border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); margin-bottom: 16px;">
                <div class="card-body" style="padding: 14px 18px;">
                    <form action="{{ route('admin.payment.index') }}" method="GET" style="margin: 0;">
                        <div class="row align-items-center" style="margin-left: -6px; margin-right: -6px;">
                            <div class="col-md-5 col-12 mb-2 mb-md-0" style="padding-left: 6px; padding-right: 6px;">
                                <select name="payment_status" class="adm-select" style="height: 38px;">
                                    <option value="">Semua Status Pembayaran</option>
                                    @foreach (['paid', 'pending', 'failed'] as $status)
                                        <option value="{{ $status }}" {{ ($filter['payment_status'] ?? '') == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5 col-12 mb-2 mb-md-0" style="padding-left: 6px; padding-right: 6px;">
                                <select name="payment_type" class="adm-select" style="height: 38px;">
                                    <option value="">Semua Metode Pembayaran</option>
                                    @foreach (['cash', 'transfer', 'qris', 'midtrans'] as $type)
                                        <option value="{{ $type }}" {{ ($filter['payment_type'] ?? '') == $type ? 'selected' : '' }}>
                                            {{ ucfirst($type) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 col-12 d-flex gap-2" style="padding-left: 6px; padding-right: 6px; gap: 8px;">
                                <button type="submit" class="adm-btn-submit" style="height: 38px; padding: 0 14px; flex: 1; justify-content: center;">
                                    <i class="fas fa-filter" style="font-size: 11px;"></i>
                                    <span>Filter</span>
                                </button>
                                @if(!empty($filter['payment_status']) || !empty($filter['payment_type']))
                                    <a href="{{ route('admin.payment.index') }}" class="adm-btn-cancel" style="height: 38px; padding: 0 12px; text-decoration: none; justify-content: center;" title="Reset Filter">
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
                                <th style="padding: 12px 14px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none;">Order ID</th>
                                <th style="padding: 12px 14px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none;">Customer</th>
                                <th style="padding: 12px 14px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none;">Kode Booking</th>
                                <th style="padding: 12px 14px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none;">Metode</th>
                                <th style="padding: 12px 14px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none;">Jumlah</th>
                                <th style="padding: 12px 14px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none;">Status Bayar</th>
                                <th style="padding: 12px 14px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none;">Waktu Bayar</th>
                                <th style="padding: 12px 14px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none; text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($datas as $data)
                                <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;">
                                    <!-- Order ID -->
                                    <td style="padding: 12px 14px; vertical-align: middle;">
                                        <span style="font-family: monospace; font-size: 12px; font-weight: 700; color: #0f172a; background: #f1f5f9; padding: 3px 8px; border-radius: 6px; border: 1px solid #e2e8f0;">
                                            {{ $data->order_id }}
                                        </span>
                                    </td>

                                    <!-- Customer -->
                                    <td style="padding: 12px 14px; vertical-align: middle;">
                                        <div style="font-size: 12.5px; font-weight: 600; color: #0f172a;">
                                            {{ $data->booking->user->name }}
                                        </div>
                                    </td>

                                    <!-- Booking Code -->
                                    <td style="padding: 12px 14px; vertical-align: middle;">
                                        <a href="{{ route('admin.booking.show', $data->booking->id) }}" style="font-family: monospace; font-size: 12px; font-weight: 700; color: #2563eb; text-decoration: none;">
                                            {{ $data->booking->kode_booking }}
                                        </a>
                                    </td>

                                    <!-- Metode -->
                                    <td style="padding: 12px 14px; vertical-align: middle;">
                                        <span style="font-size: 11.5px; font-weight: 600; text-transform: uppercase; background: #f8fafc; color: #475569; padding: 3px 8px; border-radius: 5px; border: 1px solid #e2e8f0;">
                                            {{ $data->payment_type ? ucfirst($data->payment_type) : '-' }}
                                        </span>
                                    </td>

                                    <!-- Gross Amount -->
                                    <td style="padding: 12px 14px; vertical-align: middle;">
                                        <span style="font-size: 12.5px; font-weight: 700; color: #0f172a;">
                                            Rp {{ number_format($data->gross_amount, 0, ',', '.') }}
                                        </span>
                                    </td>

                                    <!-- Status Bayar -->
                                    <td style="padding: 12px 14px; vertical-align: middle;">
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
                                        <span style="display: inline-flex; align-items: center; gap: 4px; padding: 3px 8px; border-radius: 9999px; font-size: 11px; font-weight: 600; background: {{ $psBg }}; color: {{ $psColor }}; border: 1px solid {{ $psBorder }};">
                                            <span style="width: 5px; height: 5px; border-radius: 50%; background: {{ $psColor }};"></span>
                                            {{ $data->payment_status_label }}
                                        </span>
                                    </td>

                                    <!-- Paid At -->
                                    <td style="padding: 12px 14px; vertical-align: middle; font-size: 12px; color: #64748b;">
                                        {{ $data->paid_at ? $data->paid_at->format('d M Y H:i') : '-' }}
                                    </td>

                                    <!-- Action -->
                                    <td style="padding: 12px 14px; vertical-align: middle; text-align: right;">
                                        <a href="{{ route('admin.payment.show', $data->id) }}" class="adm-btn-submit" style="display: inline-flex; height: 30px; padding: 0 10px; font-size: 11.5px; border-radius: 6px; text-decoration: none;">
                                            <i class="fas fa-eye" style="font-size: 10px;"></i>
                                            <span>Detail</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" style="padding: 48px 16px; text-align: center;">
                                        <div style="width: 52px; height: 52px; border-radius: 12px; background: #f1f5f9; color: #94a3b8; display: flex; align-items: center; justify-content: center; font-size: 22px; margin: 0 auto 12px;">
                                            <i class="fas fa-wallet"></i>
                                        </div>
                                        <div style="font-size: 14px; font-weight: 600; color: #1e293b; margin-bottom: 4px;">Tidak ada data pembayaran</div>
                                        <div style="font-size: 12px; color: #64748b;">
                                            Belum ada log transaksi pembayaran yang tercatat
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
                            Menampilkan <span style="font-weight: 600; color: #0f172a;">{{ $datas->firstItem() }}</span> sampai <span style="font-weight: 600; color: #0f172a;">{{ $datas->lastItem() }}</span> dari <span style="font-weight: 600; color: #0f172a;">{{ $datas->total() }}</span> transaksi
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