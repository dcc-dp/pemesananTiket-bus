@extends('layouts.app', ['title' => 'Data Jadwal', 'menu' => 'jadwal'])

@section('content')
    <div class="main-content">
        <section class="section">
            <!-- Page Header -->
            <div class="section-header">
                <div class="d-flex align-items-center">
                    <div class="header-icon-box mr-3">
                        <span class="material-symbols-outlined">calendar_today</span>
                    </div>
                    <div>
                        <h1 class="mb-0">Data Jadwal</h1>
                        <div class="header-subtitle">Kelola jadwal keberangkatan, armada yang bertugas, dan tarif tiket</div>
                    </div>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></div>
                    <div class="breadcrumb-item">Master Data</div>
                    <div class="breadcrumb-item active">Jadwal</div>
                </div>
            </div>

            <!-- Filter Card -->
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <span class="material-symbols-outlined mr-2 text-primary" style="font-size: 18px;">tune</span>
                        <h4 class="mb-0">Filter Jadwal</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.jadwal.index') }}" method="GET" class="form-row align-items-center">
                        <div class="col-md-3 col-12 mb-2">
                            <select name="rute" class="form-control">
                                <option value="">-- Semua Rute --</option>
                                @foreach ($rutes as $rute)
                                    <option value="{{ $rute->id_rute }}" {{ request('rute') == $rute->id_rute ? 'selected' : '' }}>
                                        {{ $rute->nama_rute }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 col-12 mb-2">
                            <select name="bus" class="form-control">
                                <option value="">-- Semua Bus --</option>
                                @foreach ($buses as $b)
                                    <option value="{{ $b->id_bus }}" {{ request('bus') == $b->id_bus ? 'selected' : '' }}>
                                        {{ $b->nama_bus }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 col-12 mb-2">
                            <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                        </div>
                        <div class="col-md-3 col-12 mb-2 d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <span class="material-symbols-outlined" style="font-size: 16px;">filter_alt</span>
                                <span>Terapkan</span>
                            </button>
                            <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary" title="Reset Filter">
                                <span class="material-symbols-outlined" style="font-size: 16px;">restart_alt</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table Card -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4>Daftar Jadwal Keberangkatan</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary">
                            <span class="material-symbols-outlined" style="font-size: 16px;">add</span>
                            <span>Tambah Jadwal</span>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Rute</th>
                                    <th>Armada Bus</th>
                                    <th>Tanggal</th>
                                    <th>Berangkat</th>
                                    <th>Tiba</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($datas as $i => $data)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td class="font-weight-bold text-dark">{{ $data->rute->nama_rute }}</td>
                                        <td>
                                            <div class="font-weight-bold text-dark">{{ $data->bus->nama_bus }}</div>
                                            <div class="text-muted small">{{ $data->bus->operator->nama_operator }}</div>
                                        </td>
                                        <td>{{ $data->tanggal->format('d M Y') }}</td>
                                        <td><span class="badge badge-secondary">{{ $data->jam_berangkat->format('H:i') }}</span></td>
                                        <td>{{ $data->jam_tiba ? $data->jam_tiba->format('H:i') : '-' }}</td>
                                        <td class="font-weight-bold text-primary">Rp {{ number_format($data->harga, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge badge-{{ $data->status == 'tersedia' ? 'success' : ($data->status == 'dibatalkan' ? 'danger' : 'secondary') }}">
                                                {{ $data->status_label }}
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.jadwal.edit', $data->id_jadwal) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <span class="material-symbols-outlined" style="font-size: 16px;">edit</span>
                                            </a>
                                            <form action="{{ route('admin.jadwal.destroy', $data->id_jadwal) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Yakin hapus jadwal ini?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <span class="material-symbols-outlined" style="font-size: 16px;">delete</span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-5 text-muted">
                                            <span class="material-symbols-outlined text-muted" style="font-size: 36px; display: block; margin-bottom: 6px;">inbox</span>
                                            <span>Belum ada data jadwal</span>
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