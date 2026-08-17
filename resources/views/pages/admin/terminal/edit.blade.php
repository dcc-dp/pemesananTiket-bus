@extends('layouts.app', ['title' => 'Edit Terminal'])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-map-marker-alt"></i> Edit Terminal</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Master Data</div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.terminal.index') }}">Terminal</a></div>
                    <div class="breadcrumb-item">Edit</div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Terminal</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.terminal.update', $data->id_terminal) }}">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kode Terminal <span class="text-danger">*</span></label>
                                            <input type="text" name="kode_terminal" class="form-control @error('kode_terminal') is-invalid @enderror"
                                                value="{{ old('kode_terminal', $data->kode_terminal) }}" required maxlength="30">
                                            @error('kode_terminal')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kota <span class="text-danger">*</span></label>
                                            <input type="text" name="kota" class="form-control @error('kota') is-invalid @enderror"
                                                value="{{ old('kota', $data->kota) }}" required maxlength="100">
                                            @error('kota')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Nama Terminal <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_terminal" class="form-control @error('nama_terminal') is-invalid @enderror"
                                        value="{{ old('nama_terminal', $data->nama_terminal) }}" required maxlength="150">
                                    @error('nama_terminal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $data->alamat) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Provinsi</label>
                                    <input type="text" name="provinsi" class="form-control" value="{{ old('provinsi', $data->provinsi) }}" maxlength="100">
                                </div>
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        <option value="aktif" {{ old('status', $data->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="nonaktif" {{ old('status', $data->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                    </select>
                                </div>
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #123E73, #1E5AA8); border: none;">
                                        <i class="fas fa-save"></i> Simpan Perubahan
                                    </button>
                                    <a href="{{ route('admin.terminal.index') }}" class="btn btn-secondary">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection