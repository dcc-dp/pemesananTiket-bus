@extends('layouts.app', ['title' => 'Data Rute'])

@section('content')
    <div class="main-content">
        <section class="section">
            <!-- PAGE HEADER: Modern Enterprise Breadcrumb & Title -->
            <div class="adm-page-header" style="margin-bottom: 22px;">
                <!-- Breadcrumb -->
                <div class="adm-breadcrumb" style="display: flex; align-items: center; gap: 6px; font-size: 11.5px; color: #64748b; margin-bottom: 12px;">
                    <a href="{{ route('admin.dashboard') }}" style="color: #64748b; text-decoration: none; font-weight: 500;">Home</a>
                    <span style="font-size: 8px; color: #94a3b8;"><i class="fas fa-chevron-right"></i></span>
                    <span style="color: #64748b;">Master Data</span>
                    <span style="font-size: 8px; color: #94a3b8;"><i class="fas fa-chevron-right"></i></span>
                    <span style="color: #0f172a; font-weight: 600;">Rute</span>
                </div>

                <!-- Page Title Row -->
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 38px; height: 38px; border-radius: 9px; background: #1d4ed8; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; box-shadow: 0 2px 6px rgba(29, 78, 216, 0.2);">
                            <i class="fas fa-route"></i>
                        </div>
                        <div>
                            <h1 style="font-size: 18px; font-weight: 700; color: #0f172a; margin: 0; line-height: 1.2; letter-spacing: -0.01em;">Data Rute</h1>
                            <p style="font-size: 12px; color: #64748b; margin: 2px 0 0 0; line-height: 1.3;">Kelola rute perjalanan antarkota, jarak tempuh, dan estimasi durasi</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CONTENT CARD -->
            <div class="card" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03); overflow: hidden; margin-bottom: 24px;">
                <div class="card-header" style="background: #ffffff; border-bottom: 1px solid #f1f5f9; padding: 12px 18px; display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <h4 style="font-size: 13.5px; font-weight: 700; color: #0f172a; margin: 0; line-height: 1.2;">Daftar Rute Perjalanan</h4>
                        <span style="font-size: 10px; font-weight: 600; background: #eff6ff; color: #1d4ed8; padding: 2px 8px; border-radius: 12px; border: 1px solid #dbeafe;">
                            {{ $datas->count() }} Rute
                        </span>
                    </div>
                    <div class="card-header-action">
                        <a href="{{ route('admin.rute.create') }}" class="btn" style="background: #1d4ed8; color: #ffffff; border: 1px solid #1d4ed8; font-size: 11.5px; font-weight: 600; padding: 6px 14px; border-radius: 6px; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 1px 2px rgba(29, 78, 216, 0.2); transition: all 0.15s ease;">
                            <i class="fas fa-plus" style="font-size: 10px;"></i>
                            <span>Tambah Rute</span>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0" style="width: 100%; border-collapse: separate; border-spacing: 0;">
                            <thead style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                                <tr>
                                    <th style="width: 45px; text-align: center; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; padding: 7px 12px; border: none;">No</th>
                                    <th style="width: 200px; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; padding: 7px 12px; border: none;">Terminal Asal</th>
                                    <th style="width: 200px; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; padding: 7px 12px; border: none;">Terminal Tujuan</th>
                                    <th style="width: 120px; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; padding: 7px 12px; border: none;">Jarak</th>
                                    <th style="width: 130px; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; padding: 7px 12px; border: none;">Estimasi Durasi</th>
                                    <th style="width: 110px; text-align: center; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; padding: 7px 12px; border: none;">Status</th>
                                    <th style="width: 90px; text-align: right; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; padding: 7px 14px; border: none;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($datas as $i => $data)
                                    <tr style="transition: background 0.15s ease;">
                                        <td style="width: 45px; text-align: center; padding: 6px 12px; vertical-align: middle; border-bottom: 1px solid #f1f5f9; font-size: 11px; font-weight: 600; color: #64748b;">
                                            {{ $i + 1 }}
                                        </td>
                                        <td style="width: 200px; padding: 6px 12px; vertical-align: middle; border-bottom: 1px solid #f1f5f9;">
                                            <div style="font-size: 11.5px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 4px;">
                                                <i class="fas fa-map-marker-alt text-primary" style="font-size: 9.5px;"></i>
                                                <span>{{ $data->terminalAsal->kota ?? '-' }}</span>
                                            </div>
                                            <small style="font-size: 10px; color: #64748b; display: block; margin-top: 1px;">
                                                {{ $data->terminalAsal->nama_terminal ?? '-' }}
                                            </small>
                                        </td>
                                        <td style="width: 200px; padding: 6px 12px; vertical-align: middle; border-bottom: 1px solid #f1f5f9;">
                                            <div style="font-size: 11.5px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 4px;">
                                                <i class="fas fa-flag-checkered text-success" style="font-size: 9.5px;"></i>
                                                <span>{{ $data->terminalTujuan->kota ?? '-' }}</span>
                                            </div>
                                            <small style="font-size: 10px; color: #64748b; display: block; margin-top: 1px;">
                                                {{ $data->terminalTujuan->nama_terminal ?? '-' }}
                                            </small>
                                        </td>
                                        <td style="width: 120px; padding: 6px 12px; vertical-align: middle; border-bottom: 1px solid #f1f5f9;">
                                            <span style="font-size: 10.5px; font-weight: 600; color: #334155; background: #f8fafc; border: 1px solid #e2e8f0; padding: 2px 6px; border-radius: 4px; display: inline-flex; align-items: center; gap: 4px;">
                                                <i class="fas fa-road" style="font-size: 8.5px; color: #94a3b8;"></i>
                                                <span>{{ $data->jarak ? $data->jarak . ' km' : '-' }}</span>
                                            </span>
                                        </td>
                                        <td style="width: 130px; padding: 6px 12px; vertical-align: middle; border-bottom: 1px solid #f1f5f9;">
                                            <span style="font-size: 10.5px; font-weight: 600; color: #475569; display: inline-flex; align-items: center; gap: 4px;">
                                                <i class="far fa-clock" style="font-size: 9.5px; color: #64748b;"></i>
                                                <span>{{ $data->estimasi_durasi ? gmdate('H:i', $data->estimasi_durasi * 60) . ' jam' : '-' }}</span>
                                            </span>
                                        </td>
                                        <td style="width: 110px; text-align: center; padding: 6px 12px; vertical-align: middle; border-bottom: 1px solid #f1f5f9;">
                                            @if ($data->status == 'aktif')
                                                <span style="font-size: 9.5px; font-weight: 600; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; padding: 2px 7px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                                                    <span style="width: 4.5px; height: 4.5px; border-radius: 50%; background: #10b981; display: inline-block;"></span>
                                                    <span>{{ $data->status_label }}</span>
                                                </span>
                                            @else
                                                <span style="font-size: 9.5px; font-weight: 600; background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0; padding: 2px 7px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                                                    <span style="width: 4.5px; height: 4.5px; border-radius: 50%; background: #94a3b8; display: inline-block;"></span>
                                                    <span>{{ $data->status_label }}</span>
                                                </span>
                                            @endif
                                        </td>
                                        <td style="width: 90px; text-align: right; padding: 6px 14px; vertical-align: middle; border-bottom: 1px solid #f1f5f9; white-space: nowrap;">
                                            <div style="display: inline-flex; align-items: center; gap: 5px;">
                                                <a href="{{ route('admin.rute.edit', $data->id_rute) }}" class="btn-action-edit" style="width: 26px; height: 26px; font-size: 11px;" title="Edit Rute">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.rute.destroy', $data->id_rute) }}" method="POST" class="d-inline"
                                                    onsubmit="return confirm('Yakin hapus rute {{ $data->nama_rute }}?');">
                                                    @csrf
                                                    <button type="submit" class="btn-action-delete" style="width: 26px; height: 26px; font-size: 11px;" title="Hapus Rute">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted" style="border: none;">
                                            <i class="fas fa-route mb-2 d-block" style="font-size: 26px; color: #cbd5e1;"></i>
                                            <span style="font-size: 12px;">Belum ada data rute perjalanan yang terdaftar.</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div style="padding: 10px 18px; background: #fafbfc; border-top: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; font-size: 11px; color: #64748b;">
                        <span>Menampilkan {{ $datas->count() }} rute</span>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection