@extends('layouts.app', ['title' => 'Data Rute', 'menu' => 'rute'])

@section('content')
    <div class="main-content">
        <section class="section">
            <!-- Page Header -->
            <div class="section-header">
                <div class="d-flex align-items-center">
                    <div class="header-icon-box mr-3">
                        <span class="material-symbols-outlined">alt_route</span>
                    </div>
                    <div>
                        <h1 class="mb-0">Data Rute</h1>
                        <div class="header-subtitle">Kelola trayek perjalanan, jarak tempuh, dan estimasi waktu</div>
                    </div>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></div>
                    <div class="breadcrumb-item">Master Data</div>
                    <div class="breadcrumb-item active">Rute</div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4>Daftar Rute Perjalanan Bus</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.rute.create') }}" class="btn btn-primary">
                            <span class="material-symbols-outlined" style="font-size: 16px;">add</span>
                            <span>Tambah Rute</span>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kota &amp; Terminal Asal</th>
                                    <th>Kota &amp; Terminal Tujuan</th>
                                    <th>Jarak Tempuh</th>
                                    <th>Estimasi Durasi</th>
                                    <th>Status</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($datas as $i => $data)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>
                                            <div class="font-weight-bold text-dark">{{ $data->terminalAsal->kota }}</div>
                                            <div class="text-muted small">{{ $data->terminalAsal->nama_terminal }}</div>
                                        </td>
                                        <td>
                                            <div class="font-weight-bold text-dark">{{ $data->terminalTujuan->kota }}</div>
                                            <div class="text-muted small">{{ $data->terminalTujuan->nama_terminal }}</div>
                                        </td>
                                        <td>{{ $data->jarak ? $data->jarak . ' km' : '-' }}</td>
                                        <td><span class="badge badge-primary">{{ $data->estimasi_durasi ? gmdate('H:i', $data->estimasi_durasi * 60) . ' jam' : '-' }}</span></td>
                                        <td>
                                            <span class="badge badge-{{ $data->status == 'aktif' ? 'success' : 'secondary' }}">
                                                {{ $data->status_label }}
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.rute.edit', $data->id_rute) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <span class="material-symbols-outlined" style="font-size: 16px;">edit</span>
                                            </a>
                                            <form action="{{ route('admin.rute.destroy', $data->id_rute) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Yakin hapus rute {{ $data->nama_rute }}?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <span class="material-symbols-outlined" style="font-size: 16px;">delete</span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <span class="material-symbols-outlined text-muted" style="font-size: 36px; display: block; margin-bottom: 6px;">inbox</span>
                                            <span>Belum ada data rute</span>
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