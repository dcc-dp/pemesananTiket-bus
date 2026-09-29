@extends('layouts.app', ['title' => 'Edit Bus'])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-bus"></i> Edit Bus</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Master Data</div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.bus.index') }}">Bus</a></div>
                    <div class="breadcrumb-item">Edit</div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Bus</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.bus.update', $data->id_bus) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>Operator <span class="text-danger">*</span></label>
                                    <select name="operator_id" class="form-control @error('operator_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Operator --</option>
                                        @foreach ($operators as $operator)
                                            <option value="{{ $operator->id }}" {{ old('operator_id', $data->operator_id) == $operator->id ? 'selected' : '' }}>
                                                {{ $operator->nama_operator }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('operator_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kode Bus <span class="text-danger">*</span></label>
                                            <input type="text" name="kode_bus" class="form-control @error('kode_bus') is-invalid @enderror"
                                                value="{{ old('kode_bus', $data->kode_bus) }}" required maxlength="30">
                                            @error('kode_bus')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Plat Nomor <span class="text-danger">*</span></label>
                                            <input type="text" name="nomor_polisi" class="form-control @error('nomor_polisi') is-invalid @enderror"
                                                value="{{ old('nomor_polisi', $data->nomor_polisi) }}" required maxlength="20">
                                            @error('nomor_polisi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Nama Bus <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_bus" class="form-control @error('nama_bus') is-invalid @enderror"
                                        value="{{ old('nama_bus', $data->nama_bus) }}" required maxlength="100">
                                    @error('nama_bus')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kelas <span class="text-danger">*</span></label>
                                            <select name="kelas" class="form-control">
                                                <option value="ekonomi" {{ old('kelas', $data->kelas) == 'ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                                                <option value="bisnis" {{ old('kelas', $data->kelas) == 'bisnis' ? 'selected' : '' }}>Bisnis</option>
                                                <option value="executive" {{ old('kelas', $data->kelas) == 'executive' ? 'selected' : '' }}>Executive</option>
                                                <option value="sleeper" {{ old('kelas', $data->kelas) == 'sleeper' ? 'selected' : '' }}>Sleeper</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kapasitas (kursi)</label>
                                            <input type="number" name="kapasitas" class="form-control @error('kapasitas') is-invalid @enderror"
                                                value="{{ old('kapasitas', $data->kapasitas) }}" min="1" max="60" required>
                                            @error('kapasitas')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Fasilitas</label>
                                    <textarea name="fasilitas" class="form-control" rows="2">{{ old('fasilitas', $data->fasilitas) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        <option value="aktif" {{ old('status', $data->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="nonaktif" {{ old('status', $data->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                        <option value="perbaikan" {{ old('status', $data->status) == 'perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                                    </select>
                                </div>
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #123E73, #1E5AA8); border: none;">
                                        <i class="fas fa-save"></i> Simpan Perubahan
                                    </button>
                                    <a href="{{ route('admin.bus.index') }}" class="btn btn-secondary">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection