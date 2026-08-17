@extends('layouts.app', ['title' => 'Tambah Rute'])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-route"></i> Tambah Rute</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Master Data</div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.rute.index') }}">Rute</a></div>
                    <div class="breadcrumb-item">Tambah</div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Rute</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.rute.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label>Terminal Asal <span class="text-danger">*</span></label>
                                    <select name="terminal_asal_id" class="form-control @error('terminal_asal_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Terminal Asal --</option>
                                        @foreach ($terminals as $terminal)
                                            <option value="{{ $terminal->id_terminal }}" {{ old('terminal_asal_id') == $terminal->id_terminal ? 'selected' : '' }}>
                                                {{ $terminal->kota }} - {{ $terminal->nama_terminal }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('terminal_asal_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Terminal Tujuan <span class="text-danger">*</span></label>
                                    <select name="terminal_tujuan_id" class="form-control @error('terminal_tujuan_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Terminal Tujuan --</option>
                                        @foreach ($terminals as $terminal)
                                            <option value="{{ $terminal->id_terminal }}" {{ old('terminal_tujuan_id') == $terminal->id_terminal ? 'selected' : '' }}>
                                                {{ $terminal->kota }} - {{ $terminal->nama_terminal }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('terminal_tujuan_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Jarak (km)</label>
                                            <input type="number" name="jarak" class="form-control" value="{{ old('jarak') }}" min="0" step="0.1">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Estimasi Durasi (menit)</label>
                                            <input type="number" name="estimasi_durasi" class="form-control" value="{{ old('estimasi_durasi') }}" min="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                    </select>
                                </div>
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #123E73, #1E5AA8); border: none;">
                                        <i class="fas fa-save"></i> Simpan
                                    </button>
                                    <a href="{{ route('admin.rute.index') }}" class="btn btn-secondary">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection