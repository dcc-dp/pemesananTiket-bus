@extends('layouts.app', ['title' => 'Data Customer'])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-users"></i> Data Customer</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Transaksi</div>
                    <div class="breadcrumb-item">Customer</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>Daftar Customer</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.customer.index') }}" method="GET" class="form-inline mb-3">
                        <input type="text" name="search" class="form-control mr-2" placeholder="Cari nama / email / username / no. hp"
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary" style="background: #1E5AA8; border: none;">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead style="background: #f8fafc;">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>No. HP</th>
                                    <th>Jumlah Booking</th>
                                    <th>Terdaftar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($datas as $i => $data)
                                    <tr>
                                        <td>{{ $datas->firstItem() + $i }}</td>
                                        <td class="font-weight-bold">{{ $data->name }}</td>
                                        <td>{{ $data->username }}</td>
                                        <td>{{ $data->email }}</td>
                                        <td>{{ $data->phone ?? '-' }}</td>
                                        <td><span class="badge badge-info">{{ $data->bookings_count }} booking</span></td>
                                        <td>{{ $data->created_at->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">Belum ada data customer</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $datas->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection