@extends('layouts.landing.app', ['menu' => 'booking'])

@section('content')
    <div style="background: linear-gradient(135deg, #0B1F3A 0%, #123E73 50%, #1E5AA8 100%); padding: 40px 0; margin-bottom: 30px;">
        <div class="container">
            <div class="d-flex align-items-center">
                <a href="{{ route('tiket.seats', $jadwal->id_jadwal) }}" class="btn btn-sm btn-outline-light mr-3"><i class="fas fa-arrow-left"></i></a>
                <div>
                    <h5 class="text-white font-weight-bold mb-0"><i class="fas fa-users"></i> Data Penumpang</h5>
                    <small class="text-white-50">
                        {{ $jadwal->rute->terminalAsal->kota }} &rarr; {{ $jadwal->rute->terminalTujuan->kota }}
                        &middot; {{ $jadwal->tanggal->format('d M Y') }} &middot; {{ $jadwal->jam_berangkat->format('H:i') }}
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="margin-bottom: 60px;">
        <form method="POST" action="{{ route('booking.store') }}" id="formBooking">
            @csrf
            <input type="hidden" name="id_jadwal" value="{{ $jadwal->id_jadwal }}">

            <div class="row">
                <div class="col-lg-8">
                    @foreach ($kursis as $i => $kursi)
                        <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
                            <div class="card-header" style="background: #f8fafc; border-radius: 12px 12px 0 0; border-bottom: 1px solid #e9ecef;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="font-weight-bold mb-0" style="color: #0B1F3A;">
                                        <i class="fas fa-chair"></i> Penumpang {{ $i + 1 }} &mdash; Kursi {{ $kursi->nomor_kursi }}
                                    </h6>
                                    <span class="badge badge-primary">Rp {{ number_format($jadwal->harga, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <input type="hidden" name="penumpang[{{ $i }}][id_kursi]" value="{{ $kursi->id_kursi }}">

                                <div class="form-group">
                                    <label class="font-weight-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="penumpang[{{ $i }}][nama]" class="form-control"
                                        placeholder="Nama sesuai KTP" required maxlength="150"
                                        value="{{ old("penumpang.{$i}.nama") }}">
                                    @error("penumpang.{$i}.nama")
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">NIK <span class="text-danger">*</span></label>
                                            <input type="text" name="penumpang[{{ $i }}][nik]" class="form-control"
                                                placeholder="16 digit NIK" required maxlength="16" pattern="[0-9]{16}"
                                                value="{{ old("penumpang.{$i}.nik") }}">
                                            @error("penumpang.{$i}.nik")
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">No. HP <span class="text-danger">*</span></label>
                                            <input type="text" name="penumpang[{{ $i }}][no_hp]" class="form-control"
                                                placeholder="08xxxxxxxxxx" required maxlength="30"
                                                value="{{ old("penumpang.{$i}.no_hp") }}">
                                            @error("penumpang.{$i}.no_hp")
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                                            <select name="penumpang[{{ $i }}][jenis_kelamin]" class="form-control" required>
                                                <option value="">-- Pilih --</option>
                                                <option value="L" {{ old("penumpang.{$i}.jenis_kelamin") == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="P" {{ old("penumpang.{$i}.jenis_kelamin") == 'P' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                            @error("penumpang.{$i}.jenis_kelamin")
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Tanggal Lahir <span class="text-danger">*</span></label>
                                            <input type="date" name="penumpang[{{ $i }}][tanggal_lahir]" class="form-control"
                                                required value="{{ old("penumpang.{$i}.tanggal_lahir") }}">
                                            @error("penumpang.{$i}.tanggal_lahir")
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm sticky-top" style="border-radius: 12px; top: 20px;">
                        <div class="card-body">
                            <h6 class="font-weight-bold" style="color: #0B1F3A;">Ringkasan</h6>
                            <hr>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Rute</span>
                                <span class="font-weight-bold text-right">{{ $jadwal->rute->terminalAsal->kota }} &rarr; {{ $jadwal->rute->terminalTujuan->kota }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Jadwal</span>
                                <span class="font-weight-bold">{{ $jadwal->tanggal->format('d M Y') }} &middot; {{ $jadwal->jam_berangkat->format('H:i') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Bus</span>
                                <span class="font-weight-bold">{{ $jadwal->bus->nama_bus }} ({{ $jadwal->bus->nomor_polisi }})</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Kursi</span>
                                <span class="font-weight-bold">{{ $kursis->pluck('nomor_kursi')->join(', ') }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="font-weight-bold" style="color: #0B1F3A;">Total ({{ $kursis->count() }} kursi)</span>
                                <span class="h5 font-weight-bold mb-0" style="color: #1E5AA8;">
                                    Rp {{ number_format($jadwal->harga * $kursis->count(), 0, ',', '.') }}
                                </span>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block font-weight-bold" style="background: linear-gradient(135deg, #123E73, #1E5AA8); border: none;">
                                Buat Pemesanan <i class="fas fa-check"></i>
                            </button>
                            <small class="text-muted d-block text-center mt-2">
                                Kursi otomatis terkunci selama proses pembayaran.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection