@extends('layouts.app', ['title' => 'Data Jadwal'])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-calendar-alt"></i> Data Jadwal</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Master Data</div>
                    <div class="breadcrumb-item">Jadwal</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>Filter</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.jadwal.index') }}" method="GET" class="form-inline">
                        <select name="rute" class="form-control mr-2 mb-2">
                            <option value="">-- Semua Rute --</option>
                            @foreach ($rutes as $rute)
                                <option value="{{ $rute->id_rute }}" {{ request('rute') == $rute->id_rute ? 'selected' : '' }}>
                                    {{ $rute->nama_rute }}
                                </option>
                            @endforeach
                        </select>
                        <select name="bus" class="form-control mr-2 mb-2">
                            <option value="">-- Semua Bus --</option>
                            @foreach ($buses as $b)
                                <option value="{{ $b->id_bus }}" {{ request('bus') == $b->id_bus ? 'selected' : '' }}>
                                    {{ $b->nama_bus }}
                                </option>
                            @endforeach
                        </select>
                        <input type="date" name="tanggal" class="form-control mr-2 mb-2" value="{{ request('tanggal') }}">
                        <button type="submit" class="btn btn-primary mb-2" style="background: #1E5AA8; border: none;">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary mb-2 ml-1">Reset</a>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>Daftar Jadwal</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary" style="background: #1E5AA8; border: none;">
                            <i class="fas fa-plus"></i> Tambah Jadwal
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead style="background: #f8fafc;">
                                <tr>
                                    <th>No</th>
                                    <th>Rute</th>
                                    <th>Bus</th>
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
                                        <td class="font-weight-bold">{{ $data->rute->nama_rute }}</td>
                                        <td>{{ $data->bus->nama_bus }}<br><small class="text-muted">{{ $data->bus->operator->nama_operator }}</small></td>
                                        <td>{{ $data->tanggal->format('d M Y') }}</td>
                                        <td>{{ $data->jam_berangkat->format('H:i') }}</td>
                                        <td>{{ $data->jam_tiba ? $data->jam_tiba->format('H:i') : '-' }}</td>
                                        <td class="font-weight-bold" style="color: #1E5AA8;">Rp {{ number_format($data->harga, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge badge-{{ $data->status == 'tersedia' ? 'success' : ($data->status == 'dibatalkan' ? 'danger' : 'secondary') }}">
                                                {{ $data->status_label }}
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.jadwal.edit', $data->id_jadwal) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.jadwal.destroy', $data->id_jadwal) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Yakin hapus jadwal ini?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4 text-muted">Belum ada data jadwal</td>
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