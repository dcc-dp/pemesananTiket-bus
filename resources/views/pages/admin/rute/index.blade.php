@extends('layouts.app', ['title' => 'Data Rute'])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-route"></i> Data Rute</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Master Data</div>
                    <div class="breadcrumb-item">Rute</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>Daftar Rute</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.rute.create') }}" class="btn btn-primary" style="background: #1E5AA8; border: none;">
                            <i class="fas fa-plus"></i> Tambah Rute
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead style="background: #f8fafc;">
                                <tr>
                                    <th>No</th>
                                    <th>Asal</th>
                                    <th>Tujuan</th>
                                    <th>Jarak</th>
                                    <th>Estimasi Durasi</th>
                                    <th>Status</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($datas as $i => $data)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td class="font-weight-bold">{{ $data->terminalAsal->kota }}<br><small class="text-muted">{{ $data->terminalAsal->nama_terminal }}</small></td>
                                        <td class="font-weight-bold">{{ $data->terminalTujuan->kota }}<br><small class="text-muted">{{ $data->terminalTujuan->nama_terminal }}</small></td>
                                        <td>{{ $data->jarak ? $data->jarak . ' km' : '-' }}</td>
                                        <td>{{ $data->estimasi_durasi ? gmdate('H:i', $data->estimasi_durasi * 60) . ' jam' : '-' }}</td>
                                        <td>
                                            <span class="badge badge-{{ $data->status == 'aktif' ? 'success' : 'secondary' }}">
                                                {{ $data->status_label }}
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.rute.edit', $data->id_rute) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.rute.destroy', $data->id_rute) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Yakin hapus rute {{ $data->nama_rute }}?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">Belum ada data rute</td>
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