@extends('layouts.app', ['title' => 'Data Terminal'])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-map-marker-alt"></i> Data Terminal</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Master Data</div>
                    <div class="breadcrumb-item">Terminal</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>Daftar Terminal</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.terminal.create') }}" class="btn btn-primary" style="background: #1E5AA8; border: none;">
                            <i class="fas fa-plus"></i> Tambah Terminal
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
                                    <th>Nama Terminal</th>
                                    <th>Kota</th>
                                    <th>Provinsi</th>
                                    <th>Alamat</th>
                                    <th>Status</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($datas as $i => $data)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td><span class="badge badge-secondary">{{ $data->kode_terminal }}</span></td>
                                        <td class="font-weight-bold">{{ $data->nama_terminal }}</td>
                                        <td>{{ $data->kota }}</td>
                                        <td>{{ $data->provinsi ?? '-' }}</td>
                                        <td>{{ $data->alamat ?? '-' }}</td>
                                        <td>
                                            <span class="badge badge-{{ $data->status == 'aktif' ? 'success' : 'secondary' }}">
                                                {{ $data->status_label }}
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.terminal.edit', $data->id_terminal) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.terminal.destroy', $data->id_terminal) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Yakin hapus terminal {{ $data->nama_terminal }}?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">Belum ada data terminal</td>
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