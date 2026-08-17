@extends('layouts.app', ['title' => 'Tambah Jadwal'])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-calendar-alt"></i> Tambah Jadwal</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Master Data</div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.jadwal.index') }}">Jadwal</a></div>
                    <div class="breadcrumb-item">Tambah</div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Jadwal</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.jadwal.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label>Rute <span class="text-danger">*</span></label>
                                    <select name="id_rute" class="form-control @error('id_rute') is-invalid @enderror" required>
                                        <option value="">-- Pilih Rute --</option>
                                        @foreach ($rutes as $rute)
                                            <option value="{{ $rute->id_rute }}" {{ old('id_rute') == $rute->id_rute ? 'selected' : '' }}>
                                                {{ $rute->nama_rute }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_rute')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Bus <span class="text-danger">*</span></label>
                                    <select name="id_bus" class="form-control @error('id_bus') is-invalid @enderror" required>
                                        <option value="">-- Pilih Bus --</option>
                                        @foreach ($buses as $b)
                                            <option value="{{ $b->id_bus }}" {{ old('id_bus') == $b->id_bus ? 'selected' : '' }}>
                                                {{ $b->nama_bus }} ({{ $b->nomor_polisi }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_bus')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Tanggal <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                                        value="{{ old('tanggal') }}" min="{{ now()->format('Y-m-d') }}" required>
                                    @error('tanggal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Jam Berangkat <span class="text-danger">*</span></label>
                                            <input type="time" name="jam_berangkat" class="form-control @error('jam_berangkat') is-invalid @enderror"
                                                value="{{ old('jam_berangkat') }}" required>
                                            @error('jam_berangkat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Jam Tiba</label>
                                            <input type="time" name="jam_tiba" class="form-control" value="{{ old('jam_tiba') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Harga (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror"
                                        value="{{ old('harga') }}" min="0" required>
                                    @error('harga')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                        <option value="penuh" {{ old('status') == 'penuh' ? 'selected' : '' }}>Penuh</option>
                                        <option value="berangkat" {{ old('status') == 'berangkat' ? 'selected' : '' }}>Berangkat</option>
                                        <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="dibatalkan" {{ old('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                </div>
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #123E73, #1E5AA8); border: none;">
                                        <i class="fas fa-save"></i> Simpan
                                    </button>
                                    <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection