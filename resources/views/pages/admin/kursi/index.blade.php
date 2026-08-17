@extends('layouts.app', ['title' => 'Data Kursi'])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-chair"></i> Data Kursi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Master Data</div>
                    <div class="breadcrumb-item">Kursi</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>Pilih Bus</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.kursi.index') }}" method="GET" class="form-inline">
                        <select name="bus" class="form-control" onchange="this.form.submit()">
                            @foreach ($buses as $b)
                                <option value="{{ $b->id_bus }}" {{ $bus && $bus->id_bus == $b->id_bus ? 'selected' : '' }}>
                                    {{ $b->nama_bus }} ({{ $b->nomor_polisi }})
                                </option>
                            @endforeach
                        </select>
                        <a href="{{ route('admin.kursi.create') }}" class="btn btn-primary ml-auto" style="background: #1E5AA8; border: none;">
                            <i class="fas fa-plus"></i> Tambah Kursi
                        </a>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>
                        Daftar Kursi
                        @if ($bus)
                            - {{ $bus->nama_bus }} ({{ $bus->nomor_polisi }})
                        @endif
                    </h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead style="background: #f8fafc;">
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Kursi</th>
                                    <th>Posisi</th>
                                    <th>Status</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($datas as $i => $data)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td><span class="badge badge-primary" style="font-size: 1rem;">{{ $data->nomor_kursi }}</span></td>
                                        <td>{{ $data->posisi ?? '-' }}</td>
                                        <td>
                                            <span class="badge badge-{{ $data->status == 'tersedia' ? 'success' : 'danger' }}">
                                                {{ $data->status_label }}
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.kursi.edit', $data->id_kursi) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.kursi.destroy', $data->id_kursi) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Yakin hapus kursi {{ $data->nomor_kursi }}?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">Belum ada data kursi untuk bus ini</td>
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