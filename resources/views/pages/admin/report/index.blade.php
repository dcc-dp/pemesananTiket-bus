@extends('layouts.app', ['title' => 'Laporan Transaksi', 'menu' => 'report'])

@section('content')
    <div class="main-content">
        <section class="section">
            <!-- Page Header -->
            <div class="section-header">
                <div class="d-flex align-items-center">
                    <div class="header-icon-box mr-3">
                        <span class="material-symbols-outlined">bar_chart</span>
                    </div>
                    <div>
                        <h1 class="mb-0">Laporan Transaksi</h1>
                        <div class="header-subtitle">Rekapitulasi penjualan tiket, pendapatan, dan analisis kinerja operasional</div>
                    </div>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></div>
                    <div class="breadcrumb-item active">Laporan</div>
                </div>
            </div>

            <!-- Filter Card -->
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <span class="material-symbols-outlined mr-2 text-primary" style="font-size: 18px;">tune</span>
                        <h4 class="mb-0">Filter Parameter Laporan</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.report.index') }}" method="GET">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Dari Tanggal</label>
                                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ $filter['tanggal_mulai'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Sampai Tanggal</label>
                                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ $filter['tanggal_akhir'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Operator</label>
                                    <select name="operator_id" class="form-control">
                                        <option value="">-- Semua Operator --</option>
                                        @foreach ($operators as $operator)
                                            <option value="{{ $operator->id }}" {{ ($filter['operator_id'] ?? '') == $operator->id ? 'selected' : '' }}>
                                                {{ $operator->nama_operator }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Armada Bus</label>
                                    <select name="bus_id" class="form-control">
                                        <option value="">-- Semua Bus --</option>
                                        @foreach ($buses as $b)
                                            <option value="{{ $b->id_bus }}" {{ ($filter['bus_id'] ?? '') == $b->id_bus ? 'selected' : '' }}>
                                                {{ $b->nama_bus }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Terminal Asal</label>
                                    <select name="terminal_asal" class="form-control">
                                        <option value="">-- Semua Asal --</option>
                                        @foreach ($terminals as $terminal)
                                            <option value="{{ $terminal->id_terminal }}" {{ ($filter['terminal_asal'] ?? '') == $terminal->id_terminal ? 'selected' : '' }}>
                                                {{ $terminal->kota }} - {{ $terminal->nama_terminal }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Terminal Tujuan</label>
                                    <select name="terminal_tujuan" class="form-control">
                                        <option value="">-- Semua Tujuan --</option>
                                        @foreach ($terminals as $terminal)
                                            <option value="{{ $terminal->id_terminal }}" {{ ($filter['terminal_tujuan'] ?? '') == $terminal->id_terminal ? 'selected' : '' }}>
                                                {{ $terminal->kota }} - {{ $terminal->nama_terminal }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Status Booking</label>
                                    <select name="status_booking" class="form-control">
                                        <option value="">-- Semua Status --</option>
                                        @foreach (['pending', 'confirmed', 'completed', 'cancelled', 'expired'] as $status)
                                            <option value="{{ $status }}" {{ ($filter['status_booking'] ?? '') == $status ? 'selected' : '' }}>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Status Pembayaran</label>
                                    <select name="status_pembayaran" class="form-control">
                                        <option value="">-- Semua Pembayaran --</option>
                                        @foreach (['paid', 'pending', 'failed'] as $status)
                                            <option value="{{ $status }}" {{ ($filter['status_pembayaran'] ?? '') == $status ? 'selected' : '' }}>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2 mt-2">
                            <button type="submit" class="btn btn-primary">
                                <span class="material-symbols-outlined" style="font-size: 16px;">filter_alt</span>
                                <span>Tampilkan Laporan</span>
                            </button>
                            <button type="submit" name="cetak" value="1" class="btn btn-secondary">
                                <span class="material-symbols-outlined" style="font-size: 16px;">print</span>
                                <span>Cetak / PDF</span>
                            </button>
                            <a href="{{ route('admin.report.index') }}" class="btn btn-secondary" title="Reset">
                                <span>Reset</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Statistic Cards -->
            <div class="row mb-4">
                <div class="col-lg-4 col-md-4 col-12 mb-3 mb-md-0">
                    <div class="modern-stat-card">
                        <div class="stat-card-top">
                            <span class="stat-card-label">Total Transaksi</span>
                            <div class="stat-icon-box stat-icon-blue">
                                <span class="material-symbols-outlined">receipt_long</span>
                            </div>
                        </div>
                        <div class="stat-card-number">{{ number_format($totalTransaksi) }}</div>
                        <div class="stat-card-footer">
                            <span>Volume Pemesanan Terfilter</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-12 mb-3 mb-md-0">
                    <div class="modern-stat-card">
                        <div class="stat-card-top">
                            <span class="stat-card-label">Total Tiket Terjual</span>
                            <div class="stat-icon-box stat-icon-emerald">
                                <span class="material-symbols-outlined">confirmation_number</span>
                            </div>
                        </div>
                        <div class="stat-card-number">{{ number_format($totalTiket) }}</div>
                        <div class="stat-card-footer">
                            <span>Kursi Penumpang Terisi</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-12">
                    <div class="modern-stat-card highlight-blue">
                        <div class="stat-card-top">
                            <span class="stat-card-label blue">Total Pendapatan</span>
                            <div class="stat-icon-box stat-icon-solid-blue">
                                <span class="material-symbols-outlined">payments</span>
                            </div>
                        </div>
                        <div class="stat-card-number text-primary">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                        <div class="stat-card-footer">
                            <span>Akumulasi Nilai Bruto</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4>Rincian Data Transaksi</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Tanggal &amp; Jam</th>
                                    <th>Customer</th>
                                    <th>Rute</th>
                                    <th>Bus</th>
                                    <th>Operator</th>
                                    <th>Total Tarif</th>
                                    <th>Status Bayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($datas as $data)
                                    <tr>
                                        <td>
                                            <span class="font-mono font-weight-bold text-primary">#{{ $data->kode_booking }}</span>
                                        </td>
                                        <td>
                                            <div>{{ \Carbon\Carbon::parse($data->tanggal)->format('d M Y') }}</div>
                                            <div class="text-muted small">{{ \Carbon\Carbon::parse($data->jam_berangkat)->format('H:i') }} WIB</div>
                                        </td>
                                        <td class="font-weight-bold text-dark">{{ $data->customer }}</td>
                                        <td>{{ $data->kota_asal }} &rarr; {{ $data->kota_tujuan }}</td>
                                        <td>{{ $data->nama_bus }}</td>
                                        <td>{{ $data->nama_operator }}</td>
                                        <td class="font-weight-bold text-dark">Rp {{ number_format($data->total_harga, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge badge-{{ $data->status_pembayaran == 'paid' ? 'success' : ($data->status_pembayaran == 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($data->status_pembayaran) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5 text-muted">
                                            <span class="material-symbols-outlined text-muted" style="font-size: 36px; display: block; margin-bottom: 6px;">inbox</span>
                                            <span>Belum ada data transaksi</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($datas->hasPages())
                        <div class="p-3 border-top">
                            {{ $datas->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection