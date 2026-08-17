<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\Jadwal;
use App\Models\Kursi;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingService
{
    public function getAvailableSeats(Jadwal $jadwal)
    {
        $terpesan = $jadwal->kursiTerpesan();

        return $jadwal->bus->kursis
            ->where('status', 'tersedia')
            ->reject(fn (Kursi $kursi) => in_array($kursi->id_kursi, $terpesan))
            ->values();
    }

    public function getUnavailableSeats(Jadwal $jadwal)
    {
        $terpesan = $jadwal->kursiTerpesan();

        return $jadwal->bus->kursis
            ->where('status', 'tersedia')
            ->filter(fn (Kursi $kursi) => in_array($kursi->id_kursi, $terpesan))
            ->values();
    }

    public function isSeatAvailable(Jadwal $jadwal, Kursi $kursi): bool
    {
        return !in_array($kursi->id_kursi, $jadwal->kursiTerpesan());
    }

    public function generateKodeBooking(): string
    {
        do {
            $kode = 'BUS-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
        } while (Booking::where('kode_booking', $kode)->exists());

        return $kode;
    }

    /**
     * Buat booking beserta kursi dan data penumpang.
     * Menggunakan transaction + row lock untuk mencegah double booking.
     *
     * @param  array<int, array>  $passengers  [{id_kursi, nama_penumpang, nik, no_hp, jenis_kelamin, tanggal_lahir}]
     */
    public function createBooking(User $user, Jadwal $jadwal, array $passengers): Booking
    {
        return DB::transaction(function () use ($user, $jadwal, $passengers) {
            if ($jadwal->status != 'tersedia') {
                throw new \Exception('Jadwal tidak tersedia untuk pemesanan.');
            }

            // Kunci jadwal untuk mencegah race condition
            $locked = Jadwal::whereKey($jadwal->id_jadwal)->lockForUpdate()->first();

            $seatIds = array_column($passengers, 'id_kursi');
            if (count($seatIds) !== count(array_unique($seatIds))) {
                throw new \Exception('Terdapat kursi yang dipilih lebih dari satu kali.');
            }

            $kursis = Kursi::whereIn('id_kursi', $seatIds)
                ->where('id_bus', $jadwal->id_bus)
                ->lockForUpdate()
                ->get();

            if ($kursis->count() !== count($seatIds)) {
                throw new \Exception('Beberapa kursi tidak ditemukan pada bus ini.');
            }

            foreach ($kursis as $kursi) {
                if (!$this->isSeatAvailable($locked, $kursi)) {
                    throw new \Exception("Kursi {$kursi->nomor_kursi} sudah dipesan orang lain.");
                }
            }

            $totalHarga = 0;
            foreach ($kursis as $kursi) {
                $totalHarga += $locked->harga;
            }

            $kode = $this->generateKodeBooking();

            $booking = Booking::create([
                'user_id' => $user->id,
                'id_jadwal' => $locked->id_jadwal,
                'kode_booking' => $kode,
                'tanggal_booking' => now(),
                'total_harga' => $totalHarga,
                'status_booking' => 'pending',
                'status_pembayaran' => 'unpaid',
                'expired_at' => $this->expiredAt($locked),
            ]);

            foreach ($kursis as $kursi) {
                $dataPenumpang = collect($passengers)->firstWhere('id_kursi', $kursi->id_kursi) ?? [];

                BookingSeat::create([
                    'booking_id' => $booking->id,
                    'id_jadwal' => $locked->id_jadwal,
                    'id_kursi' => $kursi->id_kursi,
                    'harga' => $locked->harga,
                    'nama_penumpang' => $dataPenumpang['nama_penumpang'] ?? null,
                    'nik' => $dataPenumpang['nik'] ?? null,
                    'no_hp' => $dataPenumpang['no_hp'] ?? null,
                    'jenis_kelamin' => $dataPenumpang['jenis_kelamin'] ?? null,
                    'tanggal_lahir' => $dataPenumpang['tanggal_lahir'] ?? null,
                    'status_booking' => 'pending',
                ]);
            }

            return $booking;
        });
    }

    private function expiredAt(Jadwal $jadwal): \Illuminate\Support\Carbon
    {
        $berangkat = $jadwal->tanggal->copy()->setTimeFromTimeString(
            $jadwal->jam_berangkat->format('H:i')
        );

        $expiry = now()->addHours(2);

        if ($expiry->gt($berangkat)) {
            $expiry = $berangkat;
        }

        return $expiry;
    }

    /**
     * Perbarui status booking beserta seluruh booking_seats-nya.
     */
    public function updateBookingStatus(Booking $booking, string $status): void
    {
        $allowed = ['pending', 'confirmed', 'completed', 'cancelled', 'expired'];
        if (!in_array($status, $allowed)) {
            throw new \Exception('Status booking tidak valid.');
        }

        DB::transaction(function () use ($booking, $status) {
            $booking->status_booking = $status;
            $booking->save();

            BookingSeat::where('booking_id', $booking->id)
                ->update(['status_booking' => $status]);
        });
    }

    public function seatCount(Jadwal $jadwal): int
    {
        return $this->getAvailableSeats($jadwal)->count();
    }
}