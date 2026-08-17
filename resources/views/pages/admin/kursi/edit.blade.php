@extends('layouts.app', ['title' => 'Edit Kursi'])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-chair"></i> Edit Kursi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Master Data</div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.kursi.index') }}">Kursi</a></div>
                    <div class="breadcrumb-item">Edit</div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Kursi</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.kursi.update', $data->id_kursi) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>Bus</label>
                                    <input type="text" class="form-control" value="{{ $data->bus->nama_bus }} ({{ $data->bus->nomor_polisi }})" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Nomor Kursi <span class="text-danger">*</span></label>
                                    <input type="text" name="nomor_kursi" class="form-control @error('nomor_kursi') is-invalid @enderror"
                                        value="{{ old('nomor_kursi', $data->nomor_kursi) }}" required maxlength="10">
                                    @error('nomor_kursi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Posisi</label>
                                    <input type="text" name="posisi" class="form-control" value="{{ old('posisi', $data->posisi) }}" maxlength="20">
                                </div>
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        <option value="tersedia" {{ old('status', $data->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                        <option value="rusak" {{ old('status', $data->status) == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                    </select>
                                </div>
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #123E73, #1E5AA8); border: none;">
                                        <i class="fas fa-save"></i> Simpan Perubahan
                                    </button>
                                    <a href="{{ route('admin.kursi.index') }}" class="btn btn-secondary">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection