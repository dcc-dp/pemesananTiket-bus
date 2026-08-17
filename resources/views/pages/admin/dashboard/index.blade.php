@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Dashboard</div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon" style="background: #123E73;">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Operator</h4>
                            </div>
                            <div class="card-body">{{ $totalOperator }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon" style="background: #1E5AA8;">
                            <i class="fas fa-bus"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Bus</h4>
                            </div>
                            <div class="card-body">{{ $totalBus }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon" style="background: #2dce89;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Terminal</h4>
                            </div>
                            <div class="card-body">{{ $totalTerminal }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon" style="background: #f6c23e;">
                            <i class="fas fa-route"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Rute</h4>
                            </div>
                            <div class="card-body">{{ $totalRute }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon" style="background: #6777ef;">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Jadwal Aktif</h4>
                            </div>
                            <div class="card-body">{{ $totalJadwalAktif }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon" style="background: #ffa426;">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Customer</h4>
                            </div>
                            <div class="card-body">{{ $totalCustomer }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon" style="background: #fc544b;">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Booking</h4>
                            </div>
                            <div class="card-body">{{ $totalBooking }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon" style="background: #0B1F3A;">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Booking Pending</h4>
                            </div>
                            <div class="card-body">{{ $bookingPending }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon" style="background: #2dce89;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Booking Lunas</h4>
                            </div>
                            <div class="card-body">{{ $bookingBerhasil }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon" style="background: #1E5AA8;">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Pendapatan Hari Ini</h4>
                            </div>
                            <div class="card-body">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon" style="background: #123E73;">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Pendapatan Bulan Ini</h4>
                            </div>
                            <div class="card-body">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon" style="background: #f6c23e;">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Tanggal</h4>
                            </div>
                            <div class="card-body" style="font-size: 1rem;">{{ now()->format('d M Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Pendapatan per Bulan ({{ now()->year }})</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="chartPendapatan" style="height: 250px; max-height: 250px;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Booking per Bulan ({{ now()->year }})</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="chartBooking" style="height: 250px; max-height: 250px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Rute Terpopuler</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @forelse ($ruteTerpopuler as $rute)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><i class="fas fa-route text-primary"></i> {{ $rute->rute }}</span>
                                        <span class="badge badge-primary">{{ $rute->total }} booking</span>
                                    </li>
                                @empty
                                    <li class="list-group-item text-center text-muted">Belum ada data</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Operator Terlaris</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @forelse ($operatorTerbanyak as $op)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><i class="fas fa-building text-primary"></i> {{ $op->nama_operator }}</span>
                                        <span class="badge badge-primary">{{ $op->total }} booking</span>
                                    </li>
                                @empty
                                    <li class="list-group-item text-center text-muted">Belum ada data</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Booking Terbaru</h4>
                            <div class="card-header-action">
                                <a href="{{ route('admin.booking.index') }}" class="btn btn-sm btn-primary" style="background: #1E5AA8; border: none;">Lihat Semua</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead style="background: #f8fafc;">
                                        <tr>
                                            <th>Kode</th>
                                            <th>Customer</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($bookingsTerbaru as $booking)
                                            <tr>
                                                <td><a href="{{ route('admin.booking.show', $booking->id) }}" class="font-weight-bold text-primary">{{ $booking->kode_booking }}</a></td>
                                                <td>{{ $booking->user->name }}</td>
                                                <td>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $booking->status_pembayaran == 'paid' ? 'success' : ($booking->status_pembayaran == 'pending' ? 'warning' : 'danger') }}">
                                                        {{ $booking->status_pembayaran_label }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">Belum ada booking</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Pembayaran Terbaru</h4>
                            <div class="card-header-action">
                                <a href="{{ route('admin.payment.index') }}" class="btn btn-sm btn-primary" style="background: #1E5AA8; border: none;">Lihat Semua</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead style="background: #f8fafc;">
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Customer</th>
                                            <th>Metode</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($pembayaranTerbaru as $payment)
                                            <tr>
                                                <td><a href="{{ route('admin.payment.show', $payment->id) }}" class="font-weight-bold text-primary">{{ $payment->order_id }}</a></td>
                                                <td>{{ $payment->booking->user->name }}</td>
                                                <td>{{ $payment->payment_type ? ucfirst($payment->payment_type) : '-' }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $payment->payment_status == 'paid' ? 'success' : ($payment->payment_status == 'pending' ? 'warning' : 'danger') }}">
                                                        {{ $payment->payment_status_label }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">Belum ada pembayaran</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
<script>
    var chartLabels = @json($chartLabels);
    var chartPendapatan = @json($chartPendapatan);
    var chartBooking = @json($chartBooking);

    var ctxP = document.getElementById('chartPendapatan').getContext('2d');
    new Chart(ctxP, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: chartPendapatan,
                backgroundColor: 'rgba(30,90,168,0.2)',
                borderColor: '#1E5AA8',
                borderWidth: 2,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });

    var ctxB = document.getElementById('chartBooking').getContext('2d');
    new Chart(ctxB, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Booking',
                data: chartBooking,
                backgroundColor: 'rgba(18,62,115,0.7)',
                borderColor: '#123E73',
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });
</script>
@endpush