@extends('layouts.app', ['title' => 'Data Pembayaran'])

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
                    <span style="color: #0f172a; font-weight: 600;">Pembayaran</span>
                </div>

                <!-- Page Title Row -->
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 38px; height: 38px; border-radius: 9px; background: #2563eb; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.22);">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <div>
                            <h1 style="font-size: 17px; font-weight: 700; color: #0f172a; margin: 0; line-height: 1.2; letter-spacing: -0.015em;">Data Pembayaran</h1>
                            <p style="font-size: 11.5px; color: #64748b; margin: 2px 0 0 0; line-height: 1.3;">Log transaksi pembayaran, status gateway Midtrans, dan verifikasi pelunasan tiket</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FILTER CARD CONTAINER -->
            <div class="card" style="border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); margin-bottom: 16px;">
                <div class="card-body" style="padding: 12px 16px;">
                    <form action="{{ route('admin.payment.index') }}" method="GET" style="margin: 0;">
                        <div class="row align-items-center" style="margin-left: -5px; margin-right: -5px;">
                            <div class="col-md-5 col-12 mb-2 mb-md-0" style="padding-left: 5px; padding-right: 5px;">
                                <select name="payment_status" class="adm-select" style="height: 35px; font-size: 11.5px; border-radius: 6px; padding: 0 10px; border: 1px solid #cbd5e1; width: 100%;">
                                    <option value="">Semua Status Pembayaran</option>
                                    @foreach (['paid', 'pending', 'failed'] as $status)
                                        <option value="{{ $status }}" {{ ($filter['payment_status'] ?? '') == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5 col-12 mb-2 mb-md-0" style="padding-left: 5px; padding-right: 5px;">
                                <select name="payment_type" class="adm-select" style="height: 35px; font-size: 11.5px; border-radius: 6px; padding: 0 10px; border: 1px solid #cbd5e1; width: 100%;">
                                    <option value="">Semua Metode Pembayaran</option>
                                    @foreach (['cash', 'transfer', 'qris', 'midtrans'] as $type)
                                        <option value="{{ $type }}" {{ ($filter['payment_type'] ?? '') == $type ? 'selected' : '' }}>
                                            {{ ucfirst($type) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 col-12 d-flex" style="padding-left: 5px; padding-right: 5px; gap: 6px;">
                                <button type="submit" class="btn" style="height: 35px; padding: 0 12px; background: #2563eb; color: #ffffff; border: 1px solid #2563eb; border-radius: 6px; font-size: 11.5px; font-weight: 600; display: inline-flex; align-items: center; justify-content: center; gap: 5px; flex: 1;">
                                    <i class="fas fa-filter" style="font-size: 10px;"></i>
                                    <span>Filter</span>
                                </button>
                                @if(!empty($filter['payment_status']) || !empty($filter['payment_type']))
                                    <a href="{{ route('admin.payment.index') }}" class="btn" style="height: 35px; padding: 0 12px; background: #ffffff; color: #475569; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 11.5px; font-weight: 600; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;" title="Reset Filter">
                                        <i class="fas fa-undo" style="font-size: 10px;"></i>
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
                                <th style="padding: 7px 12px; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none;">Order ID</th>
                                <th style="padding: 7px 12px; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none;">Customer</th>
                                <th style="padding: 7px 12px; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none;">Kode Booking</th>
                                <th style="padding: 7px 12px; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none;">Metode</th>
                                <th style="padding: 7px 12px; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none;">Jumlah</th>
                                <th style="padding: 7px 12px; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none;">Status Bayar</th>
                                <th style="padding: 7px 12px; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none;">Waktu Bayar</th>
                                <th style="padding: 7px 12px; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border: none; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($datas as $data)
                                <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;">
                                    <!-- Order ID -->
                                    <td style="padding: 6px 12px; vertical-align: middle;">
                                        <span style="font-family: monospace; font-size: 11px; font-weight: 700; color: #0f172a; background: #f1f5f9; padding: 2px 7px; border-radius: 5px; border: 1px solid #e2e8f0;">
                                            {{ $data->order_id }}
                                        </span>
                                    </td>

                                    <!-- Customer -->
                                    <td style="padding: 6px 12px; vertical-align: middle;">
                                        <div style="font-size: 11.5px; font-weight: 600; color: #0f172a;">
                                            {{ $data->booking->user->name }}
                                        </div>
                                    </td>

                                    <!-- Booking Code -->
                                    <td style="padding: 6px 12px; vertical-align: middle;">
                                        <a href="{{ route('admin.booking.show', $data->booking->id) }}" style="font-family: monospace; font-size: 11px; font-weight: 700; color: #2563eb; text-decoration: none;">
                                            {{ $data->booking->kode_booking }}
                                        </a>
                                    </td>

                                    <!-- Metode -->
                                    <td style="padding: 6px 12px; vertical-align: middle;">
                                        <span style="font-size: 10.5px; font-weight: 600; text-transform: uppercase; background: #f8fafc; color: #475569; padding: 2px 6px; border-radius: 4px; border: 1px solid #e2e8f0;">
                                            {{ $data->payment_type ? ucfirst($data->payment_type) : '-' }}
                                        </span>
                                    </td>

                                    <!-- Gross Amount -->
                                    <td style="padding: 6px 12px; vertical-align: middle;">
                                        <span style="font-size: 11.5px; font-weight: 700; color: #0f172a;">
                                            Rp {{ number_format($data->gross_amount, 0, ',', '.') }}
                                        </span>
                                    </td>

                                    <!-- Status Bayar -->
                                    <td style="padding: 6px 12px; vertical-align: middle;">
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
                                    </td>

                                    <!-- Paid At -->
                                    <td style="padding: 6px 12px; vertical-align: middle; font-size: 11px; color: #64748b;">
                                        {{ $data->paid_at ? $data->paid_at->format('d M Y H:i') : '-' }}
                                    </td>

                                    <!-- Action -->
                                    <td style="padding: 6px 12px; vertical-align: middle; text-align: center;">
                                        <a href="{{ route('admin.payment.show', $data->id) }}" class="btn-table-detail">
                                            <i class="fas fa-eye" style="font-size: 9px;"></i>
                                            <span>Detail</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" style="padding: 40px 16px; text-align: center;">
                                        <div style="width: 44px; height: 44px; border-radius: 10px; background: #f1f5f9; color: #94a3b8; display: flex; align-items: center; justify-content: center; font-size: 18px; margin: 0 auto 10px;">
                                            <i class="fas fa-wallet"></i>
                                        </div>
                                        <div style="font-size: 13px; font-weight: 600; color: #1e293b; margin-bottom: 3px;">Tidak ada data pembayaran</div>
                                        <div style="font-size: 11.5px; color: #64748b;">
                                            Belum ada log transaksi pembayaran yang tercatat
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($datas->hasPages())
                    <div style="padding: 10px 16px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; background: #f8fafc;">
                        <div style="font-size: 11px; color: #64748b;">
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