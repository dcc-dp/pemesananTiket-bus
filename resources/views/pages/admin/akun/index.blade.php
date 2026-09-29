@extends('layouts.app', ['title' => 'Data Akun', 'menu' => 'akun'])

@section('content')
    <div class="main-content">
        <section class="section">
            <!-- Page Header -->
            <div class="section-header">
                <div class="d-flex align-items-center">
                    <div class="header-icon-box mr-3">
                        <span class="material-symbols-outlined">manage_accounts</span>
                    </div>
                    <div>
                        <h1 class="mb-0">Data Akun</h1>
                        <div class="header-subtitle">Manajemen pengguna sistem, hak akses administrator, dan akun staf</div>
                    </div>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></div>
                    <div class="breadcrumb-item">Pengaturan</div>
                    <div class="breadcrumb-item active">Akun</div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <h4 class="mb-0">Daftar Pengguna Sistem</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.akun.create') }}" class="btn btn-primary">
                            <span class="material-symbols-outlined" style="font-size: 16px;">add</span>
                            <span>Tambah Akun</span>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter Row -->
                    <form action="{{ route('admin.akun.index') }}" method="GET" class="d-flex align-items-center gap-2 mb-3 flex-wrap">
                        <input type="text" name="search" class="form-control" style="max-width: 280px;" placeholder="Cari nama, username, email..."
                            value="{{ request('search') }}">
                        <select name="role" class="form-control" style="max-width: 180px;">
                            <option value="">-- Semua Role --</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                        </select>
                        <button type="submit" class="btn btn-primary">
                            <span class="material-symbols-outlined" style="font-size: 16px;">search</span>
                            <span>Cari</span>
                        </button>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pengguna</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>No. HP</th>
                                    <th>Hak Akses</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($datas as $i => $data)
                                    <tr>
                                        <td>{{ $datas->firstItem() + $i }}</td>
                                        <td class="font-weight-bold text-dark">{{ $data->name }}</td>
                                        <td><span class="badge badge-secondary">{{ $data->username }}</span></td>
                                        <td>{{ $data->email }}</td>
                                        <td>{{ $data->phone ?? '-' }}</td>
                                        <td>
                                            <span class="badge badge-{{ $data->role == 'admin' ? 'primary' : 'secondary' }}">
                                                {{ ucfirst($data->role) }}
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.akun.edit', $data->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <span class="material-symbols-outlined" style="font-size: 16px;">edit</span>
                                            </a>
                                            @if ($data->id != Session('user_id'))
                                                <form action="{{ route('admin.akun.destroy', $data->id) }}" method="POST" class="d-inline"
                                                    onsubmit="return confirm('Yakin hapus akun {{ $data->name }}?');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                        <span class="material-symbols-outlined" style="font-size: 16px;">delete</span>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <span class="material-symbols-outlined text-muted" style="font-size: 36px; display: block; margin-bottom: 6px;">inbox</span>
                                            <span>Belum ada data akun</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($datas->hasPages())
                        <div class="p-3 border-top">
                            {{ $datas->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection