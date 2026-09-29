@extends('layouts.app', ['title' => 'Data Akun'])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-user-cog"></i> Data Akun</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Pengaturan</div>
                    <div class="breadcrumb-item">Akun</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>Daftar Akun</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.akun.create') }}" class="btn btn-primary" style="background: #1E5AA8; border: none;">
                            <i class="fas fa-plus"></i> Tambah Akun
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.akun.index') }}" method="GET" class="form-inline mb-3">
                        <input type="text" name="search" class="form-control mr-2" placeholder="Cari nama / username / email"
                            value="{{ request('search') }}">
                        <select name="role" class="form-control mr-2">
                            <option value="">-- Semua Role --</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                        </select>
                        <button type="submit" class="btn btn-primary" style="background: #1E5AA8; border: none;">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead style="background: #f8fafc;">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>No. HP</th>
                                    <th>Role</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($datas as $i => $data)
                                    <tr>
                                        <td>{{ $datas->firstItem() + $i }}</td>
                                        <td class="font-weight-bold">{{ $data->name }}</td>
                                        <td>{{ $data->username }}</td>
                                        <td>{{ $data->email }}</td>
                                        <td>{{ $data->phone ?? '-' }}</td>
                                        <td>
                                            <span class="badge badge-{{ $data->role == 'admin' ? 'primary' : 'info' }}">
                                                {{ ucfirst($data->role) }}
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.akun.edit', $data->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if ($data->id != Session('user_id'))
                                                <form action="{{ route('admin.akun.destroy', $data->id) }}" method="POST" class="d-inline"
                                                    onsubmit="return confirm('Yakin hapus akun {{ $data->name }}?');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">Belum ada data akun</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $datas->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection