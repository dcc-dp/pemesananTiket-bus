@extends('layouts.app', ['title' => 'Data Operator', 'menu' => 'operator'])

@section('content')
    <div class="main-content">
        <section class="section">
            <!-- Page Header -->
            <div class="section-header">
                <div class="d-flex align-items-center">
                    <div class="header-icon-box mr-3">
                        <span class="material-symbols-outlined">domain</span>
                    </div>
                    <div>
                        <h1 class="mb-0">Data Operator</h1>
                        <div class="header-subtitle">Kelola mitra perusahaan otobus dan armada terdaftar</div>
                    </div>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></div>
                    <div class="breadcrumb-item">Master Data</div>
                    <div class="breadcrumb-item active">Operator</div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4>Daftar Operator Bus</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.operator.create') }}" class="btn btn-primary">
                            <span class="material-symbols-outlined" style="font-size: 16px;">add</span>
                            <span>Tambah Operator</span>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Operator</th>
                                    <th>Telepon</th>
                                    <th>Email</th>
                                    <th>Jumlah Bus</th>
                                    <th>Status</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($datas as $i => $data)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td><span class="badge badge-secondary">{{ $data->kode_operator }}</span></td>
                                        <td class="font-weight-bold text-dark">{{ $data->nama_operator }}</td>
                                        <td>{{ $data->telepon ?? '-' }}</td>
                                        <td>{{ $data->email ?? '-' }}</td>
                                        <td><span class="badge badge-primary">{{ $data->buses_count }} bus</span></td>
                                        <td>
                                            <span class="badge badge-{{ $data->status == 'aktif' ? 'success' : 'secondary' }}">
                                                {{ $data->status_label }}
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.operator.edit', $data->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <span class="material-symbols-outlined" style="font-size: 16px;">edit</span>
                                            </a>
                                            <form action="{{ route('admin.operator.destroy', $data->id) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Yakin hapus operator {{ $data->nama_operator }}?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <span class="material-symbols-outlined" style="font-size: 16px;">delete</span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5 text-muted">
                                            <span class="material-symbols-outlined text-muted" style="font-size: 36px; display: block; margin-bottom: 6px;">inbox</span>
                                            <span>Belum ada data operator</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection