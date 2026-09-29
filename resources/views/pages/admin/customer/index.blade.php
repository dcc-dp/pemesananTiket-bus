@extends('layouts.app', ['title' => 'Data Customer', 'menu' => 'customer'])

@section('content')
    <div class="main-content">
        <section class="section">
            <!-- Page Header -->
            <div class="section-header">
                <div class="d-flex align-items-center">
                    <div class="header-icon-box mr-3">
                        <span class="material-symbols-outlined">group</span>
                    </div>
                    <div>
                        <h1 class="mb-0">Data Customer</h1>
                        <div class="header-subtitle">Daftar pengguna terdaftar, kontak, dan riwayat pesanan tiket</div>
                    </div>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></div>
                    <div class="breadcrumb-item">Transaksi</div>
                    <div class="breadcrumb-item active">Customer</div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <h4 class="mb-0">Daftar Pelanggan Terdaftar</h4>
                    <form action="{{ route('admin.customer.index') }}" method="GET" class="d-flex align-items-center gap-2">
                        <input type="text" name="search" class="form-control" style="max-width: 280px;" placeholder="Cari nama, email, hp..."
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">
                            <span class="material-symbols-outlined" style="font-size: 16px;">search</span>
                            <span>Cari</span>
                        </button>
                    </form>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>No. HP</th>
                                    <th>Jumlah Booking</th>
                                    <th>Terdaftar Sejak</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($datas as $i => $data)
                                    <tr>
                                        <td>{{ $datas->firstItem() + $i }}</td>
                                        <td class="font-weight-bold text-dark">{{ $data->name }}</td>
                                        <td><span class="badge badge-secondary">{{ $data->username }}</span></td>
                                        <td>{{ $data->email }}</td>
                                        <td>{{ $data->phone ?? '-' }}</td>
                                        <td><span class="badge badge-primary">{{ $data->bookings_count }} booking</span></td>
                                        <td>{{ $data->created_at->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <span class="material-symbols-outlined text-muted" style="font-size: 36px; display: block; margin-bottom: 6px;">inbox</span>
                                            <span>Belum ada data customer</span>
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