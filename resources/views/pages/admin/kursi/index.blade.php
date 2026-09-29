@extends('layouts.app', ['title' => 'Data Kursi', 'menu' => 'kursi'])

@section('content')
    <div class="main-content">
        <section class="section">
            <!-- Page Header -->
            <div class="section-header">
                <div class="d-flex align-items-center">
                    <div class="header-icon-box mr-3">
                        <span class="material-symbols-outlined">airline_seat_recline_normal</span>
                    </div>
                    <div>
                        <h1 class="mb-0">Data Kursi</h1>
                        <div class="header-subtitle">Kelola denah nomor kursi, kelas kursi, dan ketersediaan armada</div>
                    </div>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></div>
                    <div class="breadcrumb-item">Master Data</div>
                    <div class="breadcrumb-item active">Kursi</div>
                </div>
            </div>

            <!-- Select Bus Card -->
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <span class="material-symbols-outlined mr-2 text-primary" style="font-size: 18px;">directions_bus</span>
                        <h4 class="mb-0">Pilih Armada Bus</h4>
                    </div>
                    <div class="card-header-action">
                        <a href="{{ route('admin.kursi.create') }}" class="btn btn-primary">
                            <span class="material-symbols-outlined" style="font-size: 16px;">add</span>
                            <span>Tambah Kursi</span>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.kursi.index') }}" method="GET" class="d-flex align-items-center gap-3">
                        <div style="max-width: 400px; width: 100%;">
                            <select name="bus" class="form-control" onchange="this.form.submit()">
                                @foreach ($buses as $b)
                                    <option value="{{ $b->id_bus }}"
                                        {{ $bus && $bus->id_bus == $b->id_bus ? 'selected' : '' }}>
                                        {{ $b->nama_bus }} ({{ $b->nomor_polisi }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table Card -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4>
                        Daftar Kursi
                        @if ($bus)
                            &mdash; <span class="text-primary font-weight-bold">{{ $bus->nama_bus }} ({{ $bus->nomor_polisi }})</span>
                        @endif
                    </h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Kursi</th>
                                    <th>Kelas</th>
                                    <th>Harga</th>
                                    <th>Posisi</th>
                                    <th>Status</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($datas as $i => $data)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>
                                            <span class="badge badge-primary font-weight-bold" style="font-size: 12px; padding: 4px 10px;">
                                                {{ $data->nomor_kursi }}
                                            </span>
                                        </td>
                                        <td>{{ $data->kelas ?? '-' }}</td>
                                        <td class="font-weight-bold text-dark">Rp {{ number_format($data->harga ?? 0, 0, ',', '.') }}</td>
                                        <td>{{ $data->posisi ?? '-' }}</td>
                                        <td>
                                            <span class="badge badge-{{ $data->status == 'tersedia' ? 'success' : 'danger' }}">
                                                {{ $data->status_label }}
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.kursi.edit', $data->id_kursi) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <span class="material-symbols-outlined" style="font-size: 16px;">edit</span>
                                            </a>
                                            <form action="{{ route('admin.kursi.destroy', $data->id_kursi) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Yakin hapus kursi {{ $data->nomor_kursi }}?');">
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
                                            <span>Belum ada data kursi untuk bus ini</span>
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
