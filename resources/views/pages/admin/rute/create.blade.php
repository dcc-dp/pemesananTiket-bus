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
                <div class="col-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Rute</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.rute.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label>Terminal Asal <span class="text-danger">*</span></label>
                                    <select name="terminal_asal_id" class="form-control" required>
                                        <option value="">-- Pilih Terminal Asal --</option>

                                        @foreach ($terminals as $terminal)
                                            <option value="{{ $terminal->id_terminal }}"
                                                data-lat="{{ $terminal->latitude }}" data-lng="{{ $terminal->longitude }}">
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
                                    <select name="terminal_tujuan_id" class="form-control" required>
                                        <option value="">-- Pilih Terminal Tujuan --</option>

                                        @foreach ($terminals as $terminal)
                                            <option value="{{ $terminal->id_terminal }}"
                                                data-lat="{{ $terminal->latitude }}" data-lng="{{ $terminal->longitude }}">
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
                                            {{-- <input type="number" name="jarak" class="form-control"
                                                value="{{ old('jarak') }}" min="0" step="0.1"> --}}
                                            <input type="number" name="jarak" id="jarak" class="form-control"
                                                step="0.1" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Estimasi Durasi</label>
                                            <input type="number" name="estimasi_durasi" class="form-control"
                                                value="{{ old('estimasi_durasi') }}" min="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>
                                            Nonaktif</option>
                                    </select>
                                </div>
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-primary"
                                        style="background: linear-gradient(135deg, #123E73, #1E5AA8); border: none;">
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



    {{-- untuk jarak --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const asal = document.querySelector('select[name="terminal_asal_id"]');
            const tujuan = document.querySelector('select[name="terminal_tujuan_id"]');
            const jarak = document.getElementById('jarak');

            function hitungJarak() {

                const asalOption = asal.options[asal.selectedIndex];
                const tujuanOption = tujuan.options[tujuan.selectedIndex];

                if (!asalOption.value || !tujuanOption.value) {
                    jarak.value = '';
                    return;
                }

                const lat1 = parseFloat(asalOption.dataset.lat);
                const lon1 = parseFloat(asalOption.dataset.lng);

                const lat2 = parseFloat(tujuanOption.dataset.lat);
                const lon2 = parseFloat(tujuanOption.dataset.lng);

                console.log('Asal:', lat1, lon1);
                console.log('Tujuan:', lat2, lon2);

                if (
                    isNaN(lat1) ||
                    isNaN(lon1) ||
                    isNaN(lat2) ||
                    isNaN(lon2)
                ) {
                    jarak.value = '';
                    alert('Koordinat terminal belum tersedia.');
                    return;
                }

                // Radius bumi dalam kilometer
                const R = 6371;

                const dLat = (lat2 - lat1) * Math.PI / 180;
                const dLon = (lon2 - lon1) * Math.PI / 180;

                const a =
                    Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.cos(lat1 * Math.PI / 180) *
                    Math.cos(lat2 * Math.PI / 180) *
                    Math.sin(dLon / 2) *
                    Math.sin(dLon / 2);

                const c = 2 * Math.atan2(
                    Math.sqrt(a),
                    Math.sqrt(1 - a)
                );

                const hasil = R * c;

                // Masukkan hasil ke input jarak
                jarak.value = hasil.toFixed(2);
            }

            // Jalankan ketika terminal berubah
            asal.addEventListener('change', hitungJarak);
            tujuan.addEventListener('change', hitungJarak);

        });
    </script>
@endsection
