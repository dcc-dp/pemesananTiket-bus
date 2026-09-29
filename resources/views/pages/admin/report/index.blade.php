@extends('layouts.app', ['title' => 'Laporan Transaksi'])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-chart-bar"></i> Laporan Transaksi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Laporan</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>Filter Laporan</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.report.index') }}" method="GET">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Dari Tanggal</label>
                                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ $filter['tanggal_mulai'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Sampai Tanggal</label>
                                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ $filter['tanggal_akhir'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Operator</label>
                                    <select name="operator_id" class="form-control">
                                        <option value="">-- Semua --</option>
                                        @foreach ($operators as $operator)
                                            <option value="{{ $operator->id }}" {{ ($filter['operator_id'] ?? '') == $operator->id ? 'selected' : '' }}>
                                                {{ $operator->nama_operator }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Bus</label>
                                    <select name="bus_id" class="form-control">
                                        <option value="">-- Semua --</option>
                                        @foreach ($buses as $b)
                                            <option value="{{ $b->id_bus }}" {{ ($filter['bus_id'] ?? '') == $b->id_bus ? 'selected' : '' }}>
                                                {{ $b->nama_bus }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Terminal Asal</label>
                                    <select name="terminal_asal" class="form-control">
                                        <option value="">-- Semua --</option>
                                        @foreach ($terminals as $terminal)
                                            <option value="{{ $terminal->id_terminal }}" {{ ($filter['terminal_asal'] ?? '') == $terminal->id_terminal ? 'selected' : '' }}>
                                                {{ $terminal->kota }} - {{ $terminal->nama_terminal }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Terminal Tujuan</label>
                                    <select name="terminal_tujuan" class="form-control">
                                        <option value="">-- Semua --</option>
                                        @foreach ($terminals as $terminal)
                                            <option value="{{ $terminal->id_terminal }}" {{ ($filter['terminal_tujuan'] ?? '') == $terminal->id_terminal ? 'selected' : '' }}>
                                                {{ $terminal->kota }} - {{ $terminal->nama_terminal }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status Booking</label>
                                    <select name="status_booking" class="form-control">
                                        <option value="">-- Semua --</option>
                                        @foreach (['pending', 'confirmed', 'completed', 'cancelled', 'expired'] as $status)
                                            <option value="{{ $status }}" {{ ($filter['status_booking'] ?? '') == $status ? 'selected' : '' }}>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status Pembayaran</label>
                                    <select name="status_pembayaran" class="form-control">
                                        <option value="">-- Semua --</option>
                                        @foreach (['paid', 'pending', 'failed'] as $status)
                                            <option value="{{ $status }}" {{ ($filter['status_pembayaran'] ?? '') == $status ? 'selected' : '' }}>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" style="background: #1E5AA8; border: none;">
                                <i class="fas fa-filter"></i> Tampilkan Laporan
                            </button>
                            <button type="submit" name="cetak" value="1" class="btn btn-success">
                                <i class="fas fa-print"></i> Cetak / PDF
                            </button>
                            <a href="{{ route('admin.report.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon" style="background: #1E5AA8;">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Transaksi</h4>
                            </div>
                            <div class="card-body">{{ $totalTransaksi }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon" style="background: #2dce89;">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Tiket Terjual</h4>
                            </div>
                            <div class="card-body">{{ $totalTiket }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon" style="background: #123E73;">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Pendapatan</h4>
                            </div>
                            <div class="card-body">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>Daftar Transaksi</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead style="background: #f8fafc;">
                                <tr>
                                    <th>Kode</th>
                                    <th>Tanggal</th>
                                    <th>Customer</th>
                                    <th>Rute</th>
                                    <th>Bus</th>
                                    <th>Operator</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($datas as $data)
                                    <tr>
                                        <td><span class="badge badge-primary">{{ $data->kode_booking }}</span></td>
                                        <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d M Y') }}<br><small class="text-muted">{{ \Carbon\Carbon::parse($data->jam_berangkat)->format('H:i') }}</small></td>
                                        <td>{{ $data->customer }}</td>
                                        <td>{{ $data->kota_asal }} &rarr; {{ $data->kota_tujuan }}</td>
                                        <td>{{ $data->nama_bus }}</td>
                                        <td>{{ $data->nama_operator }}</td>
                                        <td class="font-weight-bold">Rp {{ number_format($data->total_harga, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge badge-{{ $data->status_pembayaran == 'paid' ? 'success' : ($data->status_pembayaran == 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($data->status_pembayaran) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">Belum ada data transaksi</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3">
                        {{ $datas->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection