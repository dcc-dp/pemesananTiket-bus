@extends('layouts.user.app', ['title' => 'Profil'])

@section('content')
    <div class="main-content" style="padding-top: 30px;">
        <section class="section">
            <div class="section-header" style="background: transparent; box-shadow: none;">
                <h1><i class="fas fa-user"></i> Profil Saya</h1>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}" class="rounded-circle" width="80">
                        <h5 class="mt-3 mb-0 font-weight-bold" style="color: #0B1F3A;">{{ $user->name }}</h5>
                        <span class="badge badge-primary">Customer</span>
                    </div>

                    <form method="POST" action="{{ route('customer.profile.update') }}">
                        @csrf
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" value="{{ $user->username }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>No. HP</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <hr>
                        <h6 class="font-weight-bold" style="color: #0B1F3A;">Ganti Password <small class="text-muted">(opsional)</small></h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Password Baru</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Kosongkan jika tidak diganti">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary font-weight-bold" style="background: linear-gradient(135deg, #123E73, #1E5AA8); border: none;">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection