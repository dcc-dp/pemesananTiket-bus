@extends('layouts.app', ['title' => 'Data Operator'])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-building"></i> Data Operator</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Master Data</div>
                    <div class="breadcrumb-item">Operator</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>Daftar Operator Bus</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.operator.create') }}" class="btn btn-primary" style="background: #1E5AA8; border: none;">
                            <i class="fas fa-plus"></i> Tambah Operator
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
                                        <td class="font-weight-bold">{{ $data->nama_operator }}</td>
                                        <td>{{ $data->telepon ?? '-' }}</td>
                                        <td>{{ $data->email ?? '-' }}</td>
                                        <td><span class="badge badge-info">{{ $data->buses_count }} bus</span></td>
                                        <td>
                                            <span class="badge badge-{{ $data->status == 'aktif' ? 'success' : 'secondary' }}">
                                                {{ $data->status_label }}
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.operator.edit', $data->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.operator.destroy', $data->id) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Yakin hapus operator {{ $data->nama_operator }}?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">Belum ada data operator</td>
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