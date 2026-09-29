@extends('layouts.app', ['title' => 'Data Akun'])

@section('content')
    <div class="main-content">
        <section class="section">
            <!-- PAGE HEADER: Modern Enterprise Breadcrumb & Title -->
            <div class="adm-page-header" style="margin-bottom: 22px;">
                <!-- Breadcrumb -->
                <div class="adm-breadcrumb" style="display: flex; align-items: center; gap: 6px; font-size: 11.5px; color: #64748b; margin-bottom: 12px;">
                    <a href="{{ route('admin.dashboard') }}" style="color: #64748b; text-decoration: none; font-weight: 500;">Home</a>
                    <span style="font-size: 8px; color: #94a3b8;"><i class="fas fa-chevron-right"></i></span>
                    <span style="color: #64748b;">Pengaturan</span>
                    <span style="font-size: 8px; color: #94a3b8;"><i class="fas fa-chevron-right"></i></span>
                    <span style="color: #0f172a; font-weight: 600;">Akun</span>
                </div>

                <!-- Page Title Row -->
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 38px; height: 38px; border-radius: 9px; background: #1d4ed8; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; box-shadow: 0 2px 6px rgba(29, 78, 216, 0.2);">
                            <i class="fas fa-user-cog"></i>
                        </div>
                        <div>
                            <h1 style="font-size: 18px; font-weight: 700; color: #0f172a; margin: 0; line-height: 1.2; letter-spacing: -0.01em;">Data Akun Pengguna</h1>
                            <p style="font-size: 12px; color: #64748b; margin: 2px 0 0 0; line-height: 1.3;">Kelola hak akses administrator dan akun pelanggan terdaftar</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEARCH & FILTER CARD -->
            <div class="card" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03); margin-bottom: 18px;">
                <div class="card-body" style="padding: 12px 16px;">
                    <form action="{{ route('admin.akun.index') }}" method="GET" style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 10px; margin: 0;">
                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; flex: 1;">
                            <input type="text" name="search" class="adm-input" placeholder="Cari nama, username, atau email..."
                                value="{{ request('search') }}" style="min-width: 220px; max-width: 300px; height: 35px; font-size: 11.5px; border-radius: 6px; padding: 0 12px; border: 1px solid #cbd5e1;">
                            <select name="role" class="adm-select" style="width: auto; min-width: 130px; height: 35px; font-size: 11.5px; border-radius: 6px; padding: 0 10px; border: 1px solid #cbd5e1;">
                                <option value="">Semua Role</option>
                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                            </select>
                            <button type="submit" class="btn" style="height: 35px; padding: 0 13px; background: #2563eb; color: #ffffff; border: 1px solid #2563eb; border-radius: 6px; font-size: 11.5px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                                <i class="fas fa-search" style="font-size: 9.5px;"></i>
                                <span>Cari</span>
                            </button>
                            @if(request('search') || request('role'))
                                <a href="{{ route('admin.akun.index') }}" class="btn" style="height: 35px; padding: 0 12px; background: #ffffff; color: #475569; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 11.5px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px; text-decoration: none;">
                                    <i class="fas fa-undo" style="font-size: 9.5px;"></i>
                                    <span>Reset</span>
                                </a>
                            @endif
                        </div>
                        <div>
                            <a href="{{ route('admin.akun.create') }}" class="btn" style="background: #2563eb; color: #ffffff; border: 1px solid #2563eb; font-size: 11.5px; font-weight: 600; height: 35px; padding: 0 13px; border-radius: 6px; display: inline-flex; align-items: center; gap: 5px; box-shadow: 0 1px 2px rgba(37, 99, 235, 0.2); transition: all 0.15s ease;">
                                <i class="fas fa-plus" style="font-size: 9.5px;"></i>
                                <span>Tambah Akun</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- CONTENT CARD -->
            <div class="card" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03); overflow: hidden; margin-bottom: 24px;">
                <div class="card-header" style="background: #ffffff; border-bottom: 1px solid #f1f5f9; padding: 12px 18px; display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <h4 style="font-size: 13.5px; font-weight: 700; color: #0f172a; margin: 0; line-height: 1.2;">Daftar Akun</h4>
                        <span style="font-size: 10px; font-weight: 600; background: #eff6ff; color: #1d4ed8; padding: 2px 8px; border-radius: 12px; border: 1px solid #dbeafe;">
                            {{ $datas->total() }} Pengguna
                        </span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0" style="width: 100%; border-collapse: separate; border-spacing: 0;">
                            <thead style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                                <tr>
                                    <th style="width: 45px; text-align: center; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; padding: 7px 12px; border: none;">No</th>
                                    <th style="font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; padding: 7px 12px; border: none;">Nama Lengkap</th>
                                    <th style="width: 140px; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; padding: 7px 12px; border: none;">Username</th>
                                    <th style="width: 180px; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; padding: 7px 12px; border: none;">Email</th>
                                    <th style="width: 130px; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; padding: 7px 12px; border: none;">No. Handphone</th>
                                    <th style="width: 110px; text-align: center; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; padding: 7px 12px; border: none;">Peran / Role</th>
                                    <th style="width: 90px; text-align: right; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; padding: 7px 14px; border: none;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($datas as $i => $data)
                                    <tr style="transition: background 0.15s ease;">
                                        <td style="width: 45px; text-align: center; padding: 6px 12px; vertical-align: middle; border-bottom: 1px solid #f1f5f9; font-size: 11px; font-weight: 600; color: #64748b;">
                                            {{ $datas->firstItem() + $i }}
                                        </td>
                                        <td style="padding: 6px 12px; vertical-align: middle; border-bottom: 1px solid #f1f5f9;">
                                            <span style="font-size: 11.5px; font-weight: 700; color: #0f172a;">
                                                {{ $data->name }}
                                            </span>
                                            @if ($data->id == Session('user_id'))
                                                <span style="font-size: 9px; font-weight: 600; background: #eff6ff; color: #1d4ed8; padding: 1px 6px; border-radius: 4px; margin-left: 5px;">
                                                    Anda
                                                </span>
                                            @endif
                                        </td>
                                        <td style="width: 140px; padding: 6px 12px; vertical-align: middle; border-bottom: 1px solid #f1f5f9;">
                                            <span style="font-family: monospace; font-size: 10px; font-weight: 600; color: #334155; background: #f8fafc; border: 1px solid #e2e8f0; padding: 2px 6px; border-radius: 4px;">
                                                {{ $data->username }}
                                            </span>
                                        </td>
                                        <td style="width: 180px; padding: 6px 12px; vertical-align: middle; border-bottom: 1px solid #f1f5f9; font-size: 11px; color: #475569;">
                                            {{ $data->email }}
                                        </td>
                                        <td style="width: 130px; padding: 6px 12px; vertical-align: middle; border-bottom: 1px solid #f1f5f9; font-size: 11px; color: #475569;">
                                            {{ $data->phone ?? '-' }}
                                        </td>
                                        <td style="width: 110px; text-align: center; padding: 6px 12px; vertical-align: middle; border-bottom: 1px solid #f1f5f9;">
                                            @if ($data->role == 'admin')
                                                <span style="font-size: 9.5px; font-weight: 600; background: #eff6ff; color: #1d4ed8; border: 1px solid #dbeafe; padding: 2px 7px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                                                    <i class="fas fa-shield-alt" style="font-size: 8.5px;"></i>
                                                    <span>Administrator</span>
                                                </span>
                                            @else
                                                <span style="font-size: 9.5px; font-weight: 600; background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0; padding: 2px 7px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                                                    <i class="fas fa-user" style="font-size: 8px;"></i>
                                                    <span>Customer</span>
                                                </span>
                                            @endif
                                        </td>
                                        <td style="width: 90px; text-align: right; padding: 6px 14px; vertical-align: middle; border-bottom: 1px solid #f1f5f9; white-space: nowrap;">
                                            <div style="display: inline-flex; align-items: center; gap: 5px;">
                                                <a href="{{ route('admin.akun.edit', $data->id) }}" class="btn-action-edit" style="width: 26px; height: 26px; font-size: 11px;" title="Edit Akun">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                                @if ($data->id != Session('user_id'))
                                                    <form action="{{ route('admin.akun.destroy', $data->id) }}" method="POST" class="d-inline"
                                                        onsubmit="return confirm('Yakin hapus akun {{ $data->name }}?');">
                                                        @csrf
                                                        <button type="submit" class="btn-action-delete" style="width: 26px; height: 26px; font-size: 11px;" title="Hapus Akun">
                                                            <i class="far fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted" style="border: none;">
                                            <i class="fas fa-user-slash mb-2 d-block" style="font-size: 26px; color: #cbd5e1;"></i>
                                            <span style="font-size: 12px;">Tidak ada akun pengguna yang sesuai kriteria pencarian.</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($datas->hasPages())
                        <div style="padding: 12px 18px; background: #fafbfc; border-top: 1px solid #f1f5f9;">
                            {{ $datas->links() }}
                        </div>
                    @else
                        <div style="padding: 10px 18px; background: #fafbfc; border-top: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; font-size: 11px; color: #64748b;">
                            <span>Menampilkan {{ $datas->count() }} pengguna</span>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection