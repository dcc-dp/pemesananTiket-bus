@extends('layouts.app', ['title' => 'Edit Dokumen'])

@section('content')
<div class="main-content">
    <section class="section">

        <div class="section-header">
            <h1>Edit Dokumen</h1>

            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </div>

                <div class="breadcrumb-item">
                    <a href="{{ route('umkm.index') }}">
                        Data Dokumen
                    </a>
                </div>

                <div class="breadcrumb-item active">
                    Edit Dokumen
                </div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">

                    <div class="card">

                        <div class="card-header">
                            <h4>Form Edit Dokumen</h4>
                        </div>

                        <div class="card-body">

                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <form
                                action="{{ route('umkm.update',$data->id) }}"
                                method="POST"
                                enctype="multipart/form-data">

                                @csrf
                                @method('PUT')

                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label>
                                                Nomor Dokumen
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input
                                                type="text"
                                                name="nomor_dokumen"
                                                class="form-control"
                                                value="{{ old('nomor_dokumen',$data->nomor_dokumen) }}"
                                                required>
                                        </div>

                                        <div class="form-group">
                                            <label>
                                                Judul Dokumen
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input
                                                type="text"
                                                name="judul"
                                                class="form-control"
                                                value="{{ old('judul',$data->judul) }}"
                                                required>
                                        </div>

                                        <div class="form-group">
                                            <label>
                                                Kategori Dokumen
                                                <span class="text-danger">*</span>
                                            </label>

                                            <select
                                                name="kategori_id"
                                                class="form-control"
                                                required>

                                                <option value="">
                                                    Pilih Kategori
                                                </option>

                                                @foreach($jenisUsahas as $kategori)

                                                <option
                                                    value="{{ $kategori->id }}"
                                                    {{ old('kategori_id',$data->kategori_id) == $kategori->id ? 'selected' : '' }}>

                                                    {{ $kategori->nama_jenis }}

                                                </option>

                                                @endforeach

                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>
                                                Tanggal Dokumen
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input
                                                type="date"
                                                name="tanggal_dokumen"
                                                class="form-control"
                                                value="{{ old('tanggal_dokumen', $data->tanggal_dokumen ? \Carbon\Carbon::parse($data->tanggal_dokumen)->format('Y-m-d') : '') }}"
                                                required>
                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label>
                                                Versi Dokumen
                                            </label>

                                            <input
                                                type="text"
                                                name="versi"
                                                class="form-control"
                                                value="{{ old('versi',$data->versi) }}">
                                        </div>

                                        <div class="form-group">
                                            <label>
                                                Status Dokumen
                                                <span class="text-danger">*</span>
                                            </label>

                                            <select
                                                name="status"
                                                class="form-control"
                                                required>

                                                <option value="draft"
                                                    {{ old('status',$data->status) == 'draft' ? 'selected' : '' }}>
                                                    Draft
                                                </option>

                                                <option value="review"
                                                    {{ old('status',$data->status) == 'review' ? 'selected' : '' }}>
                                                    Review
                                                </option>

                                                <option value="approved"
                                                    {{ old('status',$data->status) == 'approved' ? 'selected' : '' }}>
                                                    Approved
                                                </option>

                                                <option value="obsolete"
                                                    {{ old('status',$data->status) == 'obsolete' ? 'selected' : '' }}>
                                                    Obsolete
                                                </option>

                                            </select>
                                        </div>

                                        <div class="form-group">

                                            <label>File Dokumen</label>

                                            @if($data->file_path)

                                            <div class="mb-2">

                                                <a
                                                    href="{{ asset('storage/'.$data->file_path) }}"
                                                    target="_blank"
                                                    class="btn btn-info btn-sm">

                                                    <i class="fas fa-file"></i>
                                                    Lihat File Lama

                                                </a>

                                            </div>

                                            @endif

                                            <input
                                                type="file"
                                                name="file"
                                                class="form-control">

                                            <small class="text-muted">
                                                Kosongkan jika tidak ingin mengganti file.
                                            </small>

                                        </div>

                                    </div>

                                </div>

                                <div class="form-group">

                                    <label>
                                        Deskripsi
                                    </label>

                                    <textarea
                                        name="deskripsi"
                                        rows="5"
                                        class="form-control">{{ old('deskripsi',$data->deskripsi) }}</textarea>

                                </div>

                                <div class="form-group text-center mt-4">

                                    <button
                                        type="submit"
                                        class="btn btn-primary btn-lg px-5">

                                        <i class="fas fa-save mr-2"></i>
                                        Simpan Perubahan

                                    </button>

                                    <a
                                        href="{{ route('umkm.index') }}"
                                        class="btn btn-secondary btn-lg px-5 ml-2">

                                        <i class="fas fa-arrow-left mr-2"></i>
                                        Kembali

                                    </a>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>
            </div>

        </div>

    </section>
</div>
@endsection