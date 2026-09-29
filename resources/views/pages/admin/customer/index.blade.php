@extends('layouts.app', ['title' => 'Data Pelanggan'])

@section('content')
    <div class="main-content">
        <section class="section">
            <!-- PAGE HEADER: Modern Enterprise Header & Breadcrumb -->
            <div class="adm-page-header" style="margin-bottom: 20px;">
                <!-- Subtle Breadcrumb -->
                <div class="adm-breadcrumb" style="display: flex; align-items: center; gap: 6px; font-size: 11.5px; color: #64748b; margin-bottom: 12px;">
                    <a href="{{ route('admin.dashboard') }}" style="color: #64748b; text-decoration: none; font-weight: 500;">Home</a>
                    <span style="font-size: 8px; color: #94a3b8;"><i class="fas fa-chevron-right"></i></span>
                    <span style="color: #64748b;">Pengguna</span>
                    <span style="font-size: 8px; color: #94a3b8;"><i class="fas fa-chevron-right"></i></span>
                    <span style="color: #0f172a; font-weight: 600;">Customer</span>
                </div>

                <!-- Page Title Row -->
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <div style="width: 42px; height: 42px; border-radius: 10px; background: #2563eb; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.22);">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <h1 style="font-size: 19px; font-weight: 700; color: #0f172a; margin: 0; line-height: 1.2; letter-spacing: -0.015em;">Data Pelanggan</h1>
                            <p style="font-size: 12.5px; color: #64748b; margin: 3px 0 0 0; line-height: 1.3;">Kelola data akun pelanggan serta statistik pemesanan tiket mereka</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEARCH / FILTER CARD -->
            <div class="card" style="border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); margin-bottom: 16px;">
                <div class="card-body" style="padding: 14px 18px;">
                    <form action="{{ route('admin.customer.index') }}" method="GET" style="margin: 0;">
                        <div style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center;">
                            <div style="flex: 1; min-width: 240px; position: relative;">
                                <i class="fas fa-search" style="position: absolute; left: 13px; top: 50%; transform: translateY(-50%); font-size: 13px; color: #94a3b8;"></i>
                                <input type="text" name="search" class="adm-input" placeholder="Cari nama, email, username, atau nomor HP..."
                                    value="{{ request('search') }}" style="padding-left: 36px; height: 38px;">
                            </div>
                            <button type="submit" class="adm-btn-submit" style="height: 38px; padding: 0 16px;">
                                <i class="fas fa-search" style="font-size: 12px;"></i>
                                <span>Cari</span>
                            </button>
                            @if(request('search'))
                                <a href="{{ route('admin.customer.index') }}" class="adm-btn-cancel" style="height: 38px; padding: 0 14px; text-decoration: none;">
                                    <i class="fas fa-times" style="font-size: 12px;"></i>
                                    <span>Reset</span>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- DATA TABLE CARD -->
            <div class="card" style="border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); overflow: hidden;">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" style="width: 100%; border-collapse: separate; border-spacing: 0;">
                        <thead>
                            <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                                <th style="padding: 7px 12px; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; border: none; width: 45px; text-align: center;">No</th>
                                <th style="padding: 7px 12px; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; border: none;">Pelanggan</th>
                                <th style="padding: 7px 12px; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; border: none; width: 140px;">Username</th>
                                <th style="padding: 7px 12px; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; border: none; width: 220px;">Kontak</th>
                                <th style="padding: 7px 12px; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; border: none; text-align: center; width: 130px;">Total Booking</th>
                                <th style="padding: 7px 12px; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; border: none; width: 130px;">Terdaftar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($datas as $i => $data)
                                <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;">
                                    <td style="padding: 6px 12px; vertical-align: middle; font-size: 11px; font-weight: 600; color: #64748b; text-align: center;">
                                        {{ $datas->firstItem() + $i }}
                                    </td>
                                    <td style="padding: 6px 12px; vertical-align: middle;">
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <div style="width: 26px; height: 26px; border-radius: 50%; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; flex-shrink: 0;">
                                                {{ strtoupper(substr($data->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div style="font-size: 11.5px; font-weight: 600; color: #0f172a; line-height: 1.2;">
                                                    {{ $data->name }}
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding: 6px 12px; vertical-align: middle; font-size: 11px; color: #334155; font-family: monospace;">
                                        {{ $data->username }}
                                    </td>
                                    <td style="padding: 6px 12px; vertical-align: middle;">
                                        <div style="font-size: 11.5px; color: #0f172a;">{{ $data->email ?: '-' }}</div>
                                        @if($data->phone)
                                            <div style="font-size: 10px; color: #64748b; margin-top: 1px;">
                                                <i class="fas fa-phone-alt" style="font-size: 8px; margin-right: 3px;"></i>{{ $data->phone }}
                                            </div>
                                        @endif
                                    </td>
                                    <td style="padding: 6px 12px; vertical-align: middle; text-align: center;">
                                        <span style="display: inline-flex; align-items: center; gap: 4px; padding: 2px 7px; border-radius: 9999px; font-size: 9.5px; font-weight: 600; background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0;">
                                            <i class="fas fa-ticket-alt" style="font-size: 8.5px;"></i>
                                            {{ $data->bookings_count }} Pesanan
                                        </span>
                                    </td>
                                    <td style="padding: 6px 12px; vertical-align: middle; font-size: 11px; color: #64748b;">
                                        <div style="display: flex; align-items: center; gap: 4px;">
                                            <i class="far fa-calendar-alt" style="font-size: 9.5px; color: #94a3b8;"></i>
                                            {{ $data->created_at->format('d M Y') }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="padding: 48px 16px; text-align: center;">
                                        <div style="width: 52px; height: 52px; border-radius: 12px; background: #f1f5f9; color: #94a3b8; display: flex; align-items: center; justify-content: center; font-size: 22px; margin: 0 auto 12px;">
                                            <i class="fas fa-users-slash"></i>
                                        </div>
                                        <div style="font-size: 14px; font-weight: 600; color: #1e293b; margin-bottom: 4px;">Tidak ada data pelanggan</div>
                                        <div style="font-size: 12px; color: #64748b;">
                                            @if(request('search'))
                                                Tidak ditemukan pelanggan yang cocok dengan kata kunci "{{ request('search') }}"
                                            @else
                                                Belum ada customer terdaftar dalam sistem
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($datas->hasPages())
                    <div style="padding: 14px 18px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; background: #f8fafc;">
                        <div style="font-size: 12px; color: #64748b;">
                            Menampilkan <span style="font-weight: 600; color: #0f172a;">{{ $datas->firstItem() }}</span> sampai <span style="font-weight: 600; color: #0f172a;">{{ $datas->lastItem() }}</span> dari <span style="font-weight: 600; color: #0f172a;">{{ $datas->total() }}</span> pelanggan
                        </div>
                        <div>
                            {{ $datas->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection