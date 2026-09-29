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
                                            <label>Estimasi Durasi (menit)</label>
                                            <input type="text" name="estimasi_durasi" id="estimasi_durasi"
                                                class="form-control" readonly>
                                            <small class="text-muted">
                                                Durasi dihitung otomatis berdasarkan rute perjalanan.
                                            </small>
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



    {{-- untuk jarak & durasi --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const asal = document.querySelector('select[name="terminal_asal_id"]');
            const tujuan = document.querySelector('select[name="terminal_tujuan_id"]');

            const jarak = document.getElementById('jarak');
            const durasi = document.getElementById('estimasi_durasi');


            async function hitungRute() {

                // Kosongkan hasil sebelumnya
                jarak.value = '';
                durasi.value = '';

                // Belum memilih terminal
                if (!asal.value || !tujuan.value) {
                    return;
                }

                // Terminal asal dan tujuan tidak boleh sama
                if (asal.value === tujuan.value) {

                    alert('Terminal asal dan tujuan tidak boleh sama.');

                    tujuan.value = '';

                    return;
                }

                // Tampilkan proses
                jarak.placeholder = 'Menghitung...';
                durasi.placeholder = 'Menghitung...';

                try {

                    // URL ke Laravel
                    const url = new URL(
                        "{{ route('admin.rute.calculate-distance') }}"
                    );

                    url.searchParams.append('asal', asal.value);
                    url.searchParams.append('tujuan', tujuan.value);

                    console.log('Request:', url.toString());


                    // Kirim request ke Laravel
                    const response = await fetch(url, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json'
                        }
                    });


                    // Ambil response JSON
                    const data = await response.json();

                    console.log('Response:', data);


                    // Jika terjadi error
                    if (!response.ok || !data.success) {

                        jarak.value = '';
                        durasi.value = '';

                        alert(
                            data.message ||
                            'Gagal menghitung jarak dan durasi.'
                        );

                        return;
                    }


                    // =========================
                    // ISI JARAK
                    // =========================

                    jarak.value = Number(data.jarak).toFixed(2);


                    // =========================
                    // ISI DURASI
                    // =========================

                    const totalMenit = Number(data.estimasi_durasi);

                    durasi.value = totalMenit;


                    console.log('Jarak:', data.jarak + ' km');
                    console.log('Durasi:', totalMenit + ' menit');


                } catch (error) {

                    console.error('Error:', error);

                    alert(
                        'Tidak dapat menghitung rute. ' +
                        'Pastikan koneksi internet tersedia.'
                    );

                } finally {

                    // Hilangkan placeholder
                    jarak.placeholder = '';
                    durasi.placeholder = '';

                }

            }

            asal.addEventListener('change', hitungRute);
            tujuan.addEventListener('change', hitungRute);

        });
    </script>

    {{--  --}}
@endsection
