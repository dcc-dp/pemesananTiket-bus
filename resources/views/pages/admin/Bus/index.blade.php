@extends('layouts.app', ['title' => 'Data Bus', 'menu' => 'bus'])

@section('content')
    <div class="main-content">
        <section class="section">
            <!-- Page Header -->
            <div class="section-header">
                <div class="d-flex align-items-center">
                    <div class="header-icon-box mr-3">
                        <span class="material-symbols-outlined">directions_bus</span>
                    </div>
                    <div>
                        <h1 class="mb-0">Data Bus</h1>
                        <div class="header-subtitle">Kelola armada kendaraan, nomor polisi, dan kapasitas kursi</div>
                    </div>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></div>
                    <div class="breadcrumb-item">Master Data</div>
                    <div class="breadcrumb-item active">Bus</div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4>Daftar Armada Bus</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.bus.create') }}" class="btn btn-primary">
                            <span class="material-symbols-outlined" style="font-size: 16px;">add</span>
                            <span>Tambah Bus</span>
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
                                    <th>Nama Bus</th>
                                    <th>Plat Nomor</th>
                                    <th>Operator</th>
                                    <th>Kapasitas</th>
                                    <th>Status</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($datas as $i => $data)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td><span class="badge badge-secondary">{{ $data->kode_bus }}</span></td>
                                        <td class="font-weight-bold text-dark">{{ $data->nama_bus }}</td>
                                        <td><span class="font-monospace">{{ $data->nomor_polisi }}</span></td>
                                        <td>{{ $data->operator->nama_operator ?? '-' }}</td>
                                        <td><span class="badge badge-primary">{{ $data->kapasitas }} kursi</span></td>
                                        <td>
                                            <span class="badge badge-{{ $data->status == 'aktif' ? 'success' : ($data->status == 'perbaikan' ? 'warning' : 'secondary') }}">
                                                {{ $data->status_label }}
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.bus.edit', $data->id_bus) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <span class="material-symbols-outlined" style="font-size: 16px;">edit</span>
                                            </a>
                                            <form action="{{ route('admin.bus.destroy', $data->id_bus) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Yakin hapus bus {{ $data->nama_bus }}?');">
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
                                            <span>Belum ada data bus</span>
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