@extends('layouts.landing.app', ['menu' => 'tiket'])

@section('content')
    <div style="background: linear-gradient(135deg, #0B1F3A 0%, #123E73 50%, #1E5AA8 100%); padding: 40px 0; margin-bottom: 30px;">
        <div class="container">
            <div class="d-flex align-items-center">
                <a href="{{ route('tiket.search') }}" class="btn btn-sm btn-outline-light mr-3"><i class="fas fa-arrow-left"></i></a>
                <div>
                    <h5 class="text-white font-weight-bold mb-0">
                        <i class="fas fa-bus"></i> {{ $jadwal->bus->nama_bus }}
                    </h5>
                    <small class="text-white-50">
                        {{ $jadwal->rute->terminalAsal->kota }} &rarr; {{ $jadwal->rute->terminalTujuan->kota }}
                        &middot; {{ $jadwal->tanggal->format('d M Y') }} &middot; {{ $jadwal->jam_berangkat->format('H:i') }}
                        &middot; {{ $jadwal->bus->operator->nama_operator }}
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="margin-bottom: 60px;">
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="font-weight-bold" style="color: #0B1F3A;"><i class="fas fa-chair"></i> Pilih Kursi</h6>
                            <div class="small">
                                <span class="badge badge-success">Tersedia</span>
                                <span class="badge badge-danger">Terisi</span>
                                <span class="badge badge-warning">Dipilih</span>
                            </div>
                        </div>

                        {{-- driver --}}
                        <div class="text-center mb-3">
                            <div class="d-inline-flex align-items-center justify-content-center"
                                style="width: 46px; height: 46px; border-radius: 50%; background: #e9ecef; color: #495057;">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="small text-muted mt-1">Kemudi</div>
                        </div>

                        @php
                            $availableIds = $available->pluck('id_kursi')->all();
                            $unavailableIds = $unavailable->pluck('id_kursi')->all();
                            $rows = collect($jadwal->bus->kursis)->sortBy(function ($k) {
                                preg_match('/^(\d+)([A-Z])$/', $k->nomor_kursi, $m);
                                return $m[1] * 10 + (ord($m[2]) - 65);
                            })->groupBy(function ($k) {
                                preg_match('/^(\d+)([A-Z])$/', $k->nomor_kursi, $m);
                                return (int) $m[1];
                            });
                        @endphp

                        <div style="border: 2px solid #e9ecef; border-radius: 12px; padding: 20px 10px; background: #f8fafc;">
                            @foreach ($rows as $row => $kursis)
                                <div class="d-flex justify-content-center align-items-center mb-2" style="gap: 0.6rem;">
                                    <div class="small text-muted" style="width: 22px;">{{ $row }}</div>
                                    @foreach ($kursis as $kursi)
                                        @php
                                            $isUnavailable = in_array($kursi->id_kursi, $unavailableIds);
                                            $isAvailable = in_array($kursi->id_kursi, $availableIds);
                                        @endphp
                                        <button type="button"
                                            class="seat-btn btn btn-sm font-weight-bold"
                                            data-id="{{ $kursi->id_kursi }}"
                                            data-nomor="{{ $kursi->nomor_kursi }}"
                                            data-available="{{ $isAvailable ? 1 : 0 }}"
                                            style="width: 52px; height: 52px; border-radius: 10px; font-size: 0.85rem;
                                                {{ $isUnavailable ? 'background: #e53e3e; color: #fff; border-color: #e53e3e; cursor: not-allowed; opacity: 0.75;'
                                                   : 'background: #2dce89; color: #fff; border-color: #2dce89;' }}">
                                            {{ $kursi->nomor_kursi }}
                                        </button>
                                    @endforeach
                                    <div class="small text-muted" style="width: 22px; text-align: right;">{{ $row }}</div>
                                </div>
                            @endforeach
                        </div>

                        <p class="small text-muted mt-3 mb-0"><i class="fas fa-info-circle"></i> Klik kursi hijau untuk memilih. Maksimal {{ $penumpang }} kursi (jumlah penumpang).</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm sticky-top" style="border-radius: 12px; top: 20px;">
                    <div class="card-body">
                        <h6 class="font-weight-bold" style="color: #0B1F3A;">Ringkasan</h6>
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Jadwal</span>
                            <span class="font-weight-bold">{{ $jadwal->jam_berangkat->format('H:i') }} WITA</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Bus</span>
                            <span class="font-weight-bold">{{ $jadwal->bus->nama_bus }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Kelas</span>
                            <span class="font-weight-bold">{{ ucfirst($jadwal->bus->kelas) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Harga / kursi</span>
                            <span class="font-weight-bold" style="color: #1E5AA8;">Rp {{ number_format($jadwal->harga, 0, ',', '.') }}</span>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="small text-muted font-weight-bold">Kursi Dipilih</label>
                            <div id="selectedSeats" class="d-flex flex-wrap" style="gap: 0.4rem; min-height: 34px;">
                                <span class="text-muted small">Belum ada kursi dipilih</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="font-weight-bold" style="color: #0B1F3A;">Total</span>
                            <span class="h5 font-weight-bold mb-0" id="totalHarga" style="color: #1E5AA8;">Rp 0</span>
                        </div>
                        <button id="lanjutkanBtn" class="btn btn-primary btn-block font-weight-bold" disabled style="background: linear-gradient(135deg, #123E73, #1E5AA8); border: none;">
                            Lanjutkan <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const penumpang = {{ $penumpang }};
    const hargaPerKursi = {{ $jadwal->harga }};
    const maxSeat = {{ $available->count() }};

    let selected = [];

    const seatButtons = document.querySelectorAll('.seat-btn');

    function refreshUI() {
        const container = document.getElementById('selectedSeats');
        container.innerHTML = '';

        if (selected.length === 0) {
            container.innerHTML = '<span class="text-muted small">Belum ada kursi dipilih</span>';
        }

        selected.forEach(id => {
            const btn = document.querySelector(`.seat-btn[data-id="${id}"]`);
            const span = document.createElement('span');
            span.className = 'badge badge-primary';
            span.textContent = btn.dataset.nomor;
            container.appendChild(span);
        });

        document.getElementById('totalHarga').textContent = 'Rp ' + (selected.length * hargaPerKursi).toLocaleString('id-ID');
        document.getElementById('lanjutkanBtn').disabled = selected.length === 0;
    }

    seatButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            if (this.dataset.available !== '1') return;

            const id = this.dataset.id;

            if (selected.includes(id)) {
                selected = selected.filter(s => s !== id);
                this.style.background = '#2dce89';
                this.style.borderColor = '#2dce89';
            } else {
                if (selected.length >= penumpang) {
                    alert(`Maksimal memilih ${penumpang} kursi sesuai jumlah penumpang.`);
                    return;
                }
                selected.push(id);
                this.style.background = '#f6c23e';
                this.style.borderColor = '#f6c23e';
            }

            refreshUI();
        });
    });

    document.getElementById('lanjutkanBtn').addEventListener('click', function () {
        if (selected.length === 0) return;
        const url = '{{ route("booking.form", $jadwal->id_jadwal) }}' + '?seats=' + selected.join(',');
        window.location.href = url;
    });
</script>
@endpush