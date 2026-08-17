@extends('layouts.app', ['title' => 'Tambah Kursi'])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-chair"></i> Tambah Kursi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Master Data</div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.kursi.index') }}">Kursi</a></div>
                    <div class="breadcrumb-item">Tambah</div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Kursi</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.kursi.store') }}">
                                @csrf
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
                                    <label>Nomor Kursi <span class="text-danger">*</span></label>
                                    <input type="text" name="nomor_kursi" class="form-control @error('nomor_kursi') is-invalid @enderror"
                                        value="{{ old('nomor_kursi') }}" required maxlength="10" placeholder="Contoh: 1A, 1B">
                                    @error('nomor_kursi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Posisi</label>
                                    <input type="text" name="posisi" class="form-control" value="{{ old('posisi') }}" maxlength="20"
                                        placeholder="jendela / tengah / lorong">
                                </div>
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                        <option value="rusak" {{ old('status') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                    </select>
                                </div>
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #123E73, #1E5AA8); border: none;">
                                        <i class="fas fa-save"></i> Simpan
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