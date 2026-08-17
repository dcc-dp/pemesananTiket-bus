@extends('layouts.landing.app', ['menu' => 'tiket'])

@section('content')
    <div style="background: linear-gradient(135deg, #0B1F3A 0%, #123E73 50%, #1E5AA8 100%); padding: 50px 0; margin-bottom: 40px;">
        <div class="container">
            <h1 style="color: #ffffff; font-weight: 800; margin-bottom: 0.25rem;">Cari Tiket Bus</h1>
            <p style="color: rgba(255,255,255,0.8); margin: 0;">Temukan jadwal keberangkatan terbaik untuk perjalanan Anda</p>
        </div>
    </div>

    <div class="container" style="margin-bottom: 60px;">
        <div class="row">
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body">
                        <h6 class="font-weight-bold" style="color: #0B1F3A;"><i class="fas fa-filter"></i> Filter Pencarian</h6>
                        <hr>
                        <form action="{{ route('tiket.search') }}" method="GET">
                            <div class="form-group">
                                <label class="small font-weight-bold text-muted">Dari</label>
                                <select name="terminal_asal" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($terminals as $terminal)
                                        <option value="{{ $terminal->id_terminal }}" {{ ($params['terminal_asal'] ?? '') == $terminal->id_terminal ? 'selected' : '' }}>
                                            {{ $terminal->kota }} - {{ $terminal->nama_terminal }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="small font-weight-bold text-muted">Ke</label>
                                <select name="terminal_tujuan" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($terminals as $terminal)
                                        <option value="{{ $terminal->id_terminal }}" {{ ($params['terminal_tujuan'] ?? '') == $terminal->id_terminal ? 'selected' : '' }}>
                                            {{ $terminal->kota }} - {{ $terminal->nama_terminal }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="small font-weight-bold text-muted">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" min="{{ now()->format('Y-m-d') }}"
                                    value="{{ $params['tanggal'] ?? now()->format('Y-m-d') }}" required>
                            </div>
                            <div class="form-group">
                                <label class="small font-weight-bold text-muted">Penumpang</label>
                                <input type="number" name="penumpang" class="form-control" min="1" max="5"
                                    value="{{ $params['penumpang'] ?? 1 }}" required>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="small font-weight-bold text-muted">Operator</label>
                                <select name="operator_id" class="form-control">
                                    <option value="">Semua Operator</option>
                                    @foreach ($operators as $operator)
                                        <option value="{{ $operator->id }}" {{ ($params['operator_id'] ?? '') == $operator->id ? 'selected' : '' }}>
                                            {{ $operator->nama_operator }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="small font-weight-bold text-muted">Kelas Bus</label>
                                <select name="kelas" class="form-control">
                                    <option value="">Semua Kelas</option>
                                    <option value="ekonomi" {{ ($params['kelas'] ?? '') == 'ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                                    <option value="bisnis" {{ ($params['kelas'] ?? '') == 'bisnis' ? 'selected' : '' }}>Bisnis</option>
                                    <option value="executive" {{ ($params['kelas'] ?? '') == 'executive' ? 'selected' : '' }}>Executive</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="small font-weight-bold text-muted">Maks. Harga (Rp)</label>
                                <input type="number" name="harga_max" class="form-control" min="0"
                                    value="{{ $params['harga_max'] ?? '' }}" placeholder="500000">
                            </div>
                            <div class="form-group">
                                <label class="small font-weight-bold text-muted">Berangkat Setelah</label>
                                <input type="time" name="jam_mulai" class="form-control"
                                    value="{{ $params['jam_mulai'] ?? '' }}">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block font-weight-bold" style="background: linear-gradient(135deg, #123E73, #1E5AA8); border: none;">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                @if (is_null($params))
                    <div class="card border-0 shadow-sm text-center p-5" style="border-radius: 12px;">
                        <i class="fas fa-search" style="font-size: 3rem; color: #c0c9d6; margin-bottom: 1rem;"></i>
                        <h5 style="color: #0B1F3A;">Mulai Pencarian</h5>
                        <p style="color: #6C757D;">Gunakan form filter di samping untuk mencari jadwal bus tersedia.</p>
                    </div>
                @elseif ($jadwals->count() === 0)
                    <div class="card border-0 shadow-sm text-center p-5" style="border-radius: 12px;">
                        <i class="fas fa-bus" style="font-size: 3rem; color: #c0c9d6; margin-bottom: 1rem;"></i>
                        <h5 style="color: #0B1F3A;">Tidak Ada Jadwal Tersedia</h5>
                        <p style="color: #6C757D;">Coba ubah tanggal, rute, atau filter pencarian Anda.</p>
                    </div>
                @else
                    <div class="mb-3 text-muted small">
                        Menampilkan {{ $jadwals->count() }} jadwal untuk <strong>{{ \Carbon\Carbon::parse($params['tanggal'])->format('d M Y') }}</strong>
                    </div>
                    @foreach ($jadwals as $jadwal)
                        <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-3 text-center">
                                        <div class="d-inline-flex align-items-center justify-content-center"
                                            style="width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, #123E73, #1E5AA8); color: #fff; font-size: 1.3rem;">
                                            <i class="fas fa-bus"></i>
                                        </div>
                                        <h6 class="mt-2 mb-0 font-weight-bold" style="color: #0B1F3A;">{{ $jadwal->bus->nama_bus }}</h6>
                                        <small class="text-muted">{{ $jadwal->bus->operator->nama_operator }}</small>
                                        <div>
                                            <span class="badge badge-info">{{ ucfirst($jadwal->bus->kelas) }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <div class="text-center">
                                                <h5 class="font-weight-bold mb-0" style="color: #0B1F3A;">{{ \Carbon\Carbon::parse($jadwal->jam_berangkat)->format('H:i') }}</h5>
                                                <small class="text-muted">{{ $jadwal->rute->terminalAsal->kota }}</small>
                                            </div>
                                            <div class="mx-3 text-center flex-grow-1">
                                                <div class="small text-muted">{{ $jadwal->rute->estimasi_durasi ? \Carbon\Carbon::parse($jadwal->rute->estimasi_durasi)->format('H:i') . ' jam' : '' }}</div>
                                                <div style="border-top: 2px solid #1E5AA8; position: relative; margin: 6px 0;">
                                                    <i class="fas fa-circle" style="position: absolute; top: -6px; left: 0; color: #1E5AA8; font-size: 0.5rem;"></i>
                                                    <i class="fas fa-bus" style="position: absolute; top: -9px; right: 0; color: #1E5AA8; font-size: 0.8rem;"></i>
                                                </div>
                                                <small class="text-muted">{{ $jadwal->rute->terminalAsal->nama_terminal }} &rarr; {{ $jadwal->rute->terminalTujuan->nama_terminal }}</small>
                                            </div>
                                            <div class="text-center">
                                                <h5 class="font-weight-bold mb-0" style="color: #0B1F3A;">{{ \Carbon\Carbon::parse($jadwal->jam_berangkat)->addMinutes($jadwal->rute->estimasi_durasi ?? 0)->format('H:i') }}</h5>
                                                <small class="text-muted">{{ $jadwal->rute->terminalTujuan->kota }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <div class="h5 font-weight-bold mb-1" style="color: #1E5AA8;">Rp {{ number_format($jadwal->harga, 0, ',', '.') }}</div>
                                        <div class="small text-success mb-2"><i class="fas fa-chair"></i> {{ $jadwal->available_seats }} kursi tersisa</div>
                                        <a href="{{ route('tiket.seats', $jadwal->id_jadwal) }}?penumpang={{ $params['penumpang'] }}"
                                            class="btn btn-primary btn-block font-weight-bold" style="background: #1E5AA8; border: none;">
                                            Pilih Kursi
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection