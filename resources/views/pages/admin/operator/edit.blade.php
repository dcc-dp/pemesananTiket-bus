@extends('layouts.app', ['title' => 'Edit Operator'])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-building"></i> Edit Operator</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Master Data</div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.operator.index') }}">Operator</a></div>
                    <div class="breadcrumb-item">Edit</div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Operator</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.operator.update', $data->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>Kode Operator <span class="text-danger">*</span></label>
                                    <input type="text" name="kode_operator" class="form-control @error('kode_operator') is-invalid @enderror"
                                        value="{{ old('kode_operator', $data->kode_operator) }}" required maxlength="30">
                                    @error('kode_operator')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Nama Operator <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_operator" class="form-control @error('nama_operator') is-invalid @enderror"
                                        value="{{ old('nama_operator', $data->nama_operator) }}" required maxlength="150">
                                    @error('nama_operator')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $data->alamat) }}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Telepon</label>
                                            <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $data->telepon) }}" maxlength="30">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email" class="form-control" value="{{ old('email', $data->email) }}" maxlength="150">
                                        </div>
                                    </div>
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
                                    <a href="{{ route('admin.operator.index') }}" class="btn btn-secondary">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection