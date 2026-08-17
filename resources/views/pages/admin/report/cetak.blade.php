@extends('layouts.app', ['title' => 'Cetak Laporan'])

@push('styles')
<style>
    @media print {
        .navbar, .main-sidebar, .main-footer, .no-print { display: none !important; }
        .main-content { margin: 0 !important; padding: 0 !important; }
        body { background: #fff !important; }
    }
    @page { size: A4 landscape; margin: 15mm; }
</style>
@endpush

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header no-print">
                <h1><i class="fas fa-print"></i> Cetak Laporan</h1>
                <div class="section-header-button">
                    <button onclick="window.print()" class="btn btn-success"><i class="fas fa-print"></i> Cetak</button>
                    <a href="{{ route('admin.report.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>

            <div class="card">
                <div class="card-header text-center">
                    <h4 class="m-0">{{ $title }}</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3 small text-muted">
                        <div>Periode:
                            {{ isset($filter['tanggal_mulai']) && $filter['tanggal_mulai'] ? $filter['tanggal_mulai'] : '-' }}
                            s/d
                            {{ isset($filter['tanggal_akhir']) && $filter['tanggal_akhir'] ? $filter['tanggal_akhir'] : '-' }}
                        </div>
                        <div>Dicetak: {{ now()->format('d M Y H:i') }}</div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Tanggal</th>
                                    <th>Customer</th>
                                    <th>Rute</th>
                                    <th>Bus</th>
                                    <th>Operator</th>
                                    <th>Kelas</th>
                                    <th>Total</th>
                                    <th>Status Bayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($datas as $i => $data)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $data->kode_booking }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d M Y') }}</td>
                                        <td>{{ $data->customer }}</td>
                                        <td>{{ $data->kota_asal }} &rarr; {{ $data->kota_tujuan }}</td>
                                        <td>{{ $data->nama_bus }}</td>
                                        <td>{{ $data->nama_operator }}</td>
                                        <td>{{ ucfirst($data->kelas) }}</td>
                                        <td class="text-right">Rp {{ number_format($data->total_harga, 0, ',', '.') }}</td>
                                        <td>{{ ucfirst($data->status_pembayaran) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if ($datas->count())
                                <tfoot>
                                    <tr>
                                        <th colspan="8" class="text-right">Total Pendapatan (Lunas)</th>
                                        <th class="text-right">
                                            Rp {{ number_format($datas->where('status_pembayaran', 'paid')->sum('total_harga'), 0, ',', '.') }}
                                        </th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection