@extends('layouts.app', ['title' => 'Data Bus'])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-bus"></i> Data Bus</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Master Data</div>
                    <div class="breadcrumb-item">Bus</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>Daftar Armada Bus</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.bus.create') }}" class="btn btn-primary" style="background: #1E5AA8; border: none;">
                            <i class="fas fa-plus"></i> Tambah Bus
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead style="background: #f8fafc;">
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Bus</th>
                                    <th>Plat Nomor</th>
                                    <th>Operator</th>
                                    <th>Kelas</th>
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
                                        <td class="font-weight-bold">{{ $data->nama_bus }}</td>
                                        <td>{{ $data->nomor_polisi }}</td>
                                        <td>{{ $data->operator->nama_operator }}</td>
                                        <td><span class="badge badge-info">{{ $data->kelas_label }}</span></td>
                                        <td>{{ $data->kapasitas }} kursi</td>
                                        <td>
                                            <span class="badge badge-{{ $data->status == 'aktif' ? 'success' : ($data->status == 'perbaikan' ? 'warning' : 'secondary') }}">
                                                {{ $data->status_label }}
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.bus.edit', $data->id_bus) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.bus.destroy', $data->id_bus) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Yakin hapus bus {{ $data->nama_bus }}?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4 text-muted">Belum ada data bus</td>
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