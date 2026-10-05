@extends('layouts.app', ['title' => 'Data Kursi'])

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
                    <span style="color: #0f172a; font-weight: 600;">Kursi</span>
                </div>

                <!-- Page Title Row -->
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 38px; height: 38px; border-radius: 9px; background: #1d4ed8; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; box-shadow: 0 2px 6px rgba(29, 78, 216, 0.2);">
                            <i class="fas fa-chair"></i>
                        </div>
                        <div>
                            <h1 style="font-size: 18px; font-weight: 700; color: #0f172a; margin: 0; line-height: 1.2; letter-spacing: -0.01em;">Data Kursi</h1>
                            <p style="font-size: 12px; color: #64748b; margin: 2px 0 0 0; line-height: 1.3;">Manajemen nomor kursi armada, kelas tempat duduk, dan status ketersediaan</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BUS SELECTOR & ACTION CARD -->
            <div class="card" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03); margin-bottom: 18px;">
                <div class="card-body" style="padding: 14px 18px;">
                    <form action="{{ route('admin.kursi.index') }}" method="GET" style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; margin: 0;">
                        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                            <label style="font-size: 12px; font-weight: 600; color: #334155; margin: 0;">
                                <i class="fas fa-bus text-primary mr-1"></i> Pilih Armada Bus:
                            </label>
                            <select name="bus" class="adm-select" onchange="this.form.submit()" style="width: auto; min-width: 260px; height: 38px; font-size: 12.5px;">
                                @foreach ($buses as $b)
                                    <option value="{{ $b->id_bus }}" {{ $bus && $bus->id_bus == $b->id_bus ? 'selected' : '' }}>
                                        {{ $b->nama_bus }} ({{ $b->nomor_polisi }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <a href="{{ route('admin.kursi.create') }}" class="btn" style="background: #1d4ed8; color: #ffffff; border: 1px solid #1d4ed8; font-size: 11.5px; font-weight: 600; padding: 7px 14px; border-radius: 6px; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 1px 2px rgba(29, 78, 216, 0.2); transition: all 0.15s ease;">
                                <i class="fas fa-plus" style="font-size: 10px;"></i>
                                <span>Tambah Kursi</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- CONTENT CARD -->
            <div class="card" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03); overflow: hidden; margin-bottom: 24px;">
                <div class="card-header" style="background: #ffffff; border-bottom: 1px solid #f1f5f9; padding: 12px 18px; display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <h4 style="font-size: 13.5px; font-weight: 700; color: #0f172a; margin: 0; line-height: 1.2;">
                            Daftar Kursi @if ($bus) &mdash; <span class="text-primary">{{ $bus->nama_bus }}</span> ({{ $bus->nomor_polisi }}) @endif
                        </h4>
                        <span style="font-size: 10px; font-weight: 600; background: #eff6ff; color: #1d4ed8; padding: 2px 8px; border-radius: 12px; border: 1px solid #dbeafe;">
                            {{ $datas->count() }} Kursi
                        </span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0" style="width: 100%; border-collapse: separate; border-spacing: 0;">
                            <thead style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                                <tr>
                                    <th style="width: 5%; text-align: center; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; padding: 7px 12px; border: none;">No</th>
                                    <th style="width: 12%; text-align: center; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; padding: 7px 12px; border: none;">No. Kursi</th>
                                    <th style="width: 20%; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; padding: 7px 12px; border: none;">Kelas</th>
                                    <th style="width: 22%; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; padding: 7px 12px; border: none;">Tarif Kursi</th>
                                    <th style="width: 16%; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; padding: 7px 12px; border: none;">Posisi</th>
                                    <th style="width: 14%; text-align: center; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; padding: 7px 12px; border: none;">Status</th>
                                    <th style="width: 11%; text-align: right; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; padding: 7px 14px; border: none;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($datas as $i => $data)
                                    <tr style="transition: background 0.15s ease;">
                                        <td style="text-align: center; padding: 6px 12px; vertical-align: middle; border-bottom: 1px solid #f1f5f9; font-size: 11px; font-weight: 600; color: #64748b;">
                                            {{ $i + 1 }}
                                        </td>
                                        <td style="text-align: center; padding: 6px 12px; vertical-align: middle; border-bottom: 1px solid #f1f5f9;">
                                            <span style="font-family: monospace; font-size: 10.5px; font-weight: 700; background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; padding: 2px 8px; border-radius: 5px; display: inline-block;">
                                                {{ $data->nomor_kursi }}
                                            </span>
                                        </td>
                                        <td style="padding: 6px 12px; vertical-align: middle; border-bottom: 1px solid #f1f5f9;">
                                            <span style="font-size: 11.5px; font-weight: 600; text-transform: capitalize; color: #0f172a;">
                                                {{ $data->kelas ?? '-' }}
                                            </span>
                                        </td>
                                        <td style="padding: 6px 12px; vertical-align: middle; border-bottom: 1px solid #f1f5f9;">
                                            @php
                                                $tarifDisplay = ($data->harga && (int) $data->harga > 0)
                                                    ? (int) $data->harga
                                                    : ($latestJadwal ? (int) $latestJadwal->harga : (int) ($defaultHargaJadwal ?? $data->getTarif()));
                                            @endphp
                                            <span style="font-size: 11.5px; font-weight: 700; color: #0f172a; font-family: monospace;">
                                                Rp {{ number_format($tarifDisplay, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td style="padding: 6px 12px; vertical-align: middle; border-bottom: 1px solid #f1f5f9; font-size: 11px; color: #475569;">
                                            @if ($data->posisi)
                                                <span style="font-size: 9.5px; font-weight: 500; background: #f8fafc; border: 1px solid #e2e8f0; padding: 1.5px 6px; border-radius: 4px; text-transform: capitalize;">
                                                    {{ $data->posisi }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td style="text-align: center; padding: 6px 12px; vertical-align: middle; border-bottom: 1px solid #f1f5f9;">
                                            @if ($data->status == 'tersedia')
                                                <span style="font-size: 9.5px; font-weight: 600; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; padding: 2px 7px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                                                    <span style="width: 4.5px; height: 4.5px; border-radius: 50%; background: #10b981; display: inline-block;"></span>
                                                    <span>{{ $data->status_label }}</span>
                                                </span>
                                            @else
                                                <span style="font-size: 9.5px; font-weight: 600; background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; padding: 2px 7px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                                                    <span style="width: 4.5px; height: 4.5px; border-radius: 50%; background: #ef4444; display: inline-block;"></span>
                                                    <span>{{ $data->status_label }}</span>
                                                </span>
                                            @endif
                                        </td>
                                        <td style="text-align: right; padding: 6px 14px; vertical-align: middle; border-bottom: 1px solid #f1f5f9; white-space: nowrap;">
                                            <div style="display: inline-flex; align-items: center; gap: 5px;">
                                                <a href="{{ route('admin.kursi.edit', $data->id_kursi) }}" class="btn-action-edit" style="width: 26px; height: 26px; font-size: 11px;" title="Edit Kursi">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.kursi.destroy', $data->id_kursi) }}" method="POST" class="d-inline"
                                                    onsubmit="return confirm('Yakin hapus kursi {{ $data->nomor_kursi }}?');">
                                                    @csrf
                                                    <button type="submit" class="btn-action-delete" style="width: 26px; height: 26px; font-size: 11px;" title="Hapus Kursi">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted" style="border: none;">
                                            <i class="fas fa-chair mb-2 d-block" style="font-size: 26px; color: #cbd5e1;"></i>
                                            <span style="font-size: 12px;">Belum ada data kursi untuk armada bus ini.</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div style="padding: 10px 18px; background: #fafbfc; border-top: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; font-size: 11px; color: #64748b;">
                        <span>Menampilkan {{ $datas->count() }} kursi</span>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
