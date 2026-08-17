<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\Jadwal;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::where('role', 'customer')->take(6)->get();
        $jadwals = Jadwal::with(['bus', 'rute'])->get();

        if ($customers->isEmpty() || $jadwals->isEmpty()) {
            return;
        }

        foreach ($customers as $customer) {
            $jadwal = $jadwals->random();
            $jumlahKursi = rand(1, 2);

            $terpesan = $jadwal->bookingSeats()
                ->whereIn('status_booking', ['pending', 'confirmed', 'completed'])
                ->pluck('id_kursi')
                ->toArray();

            $kursis = $jadwal->bus->kursis
                ->where('status', 'tersedia')
                ->reject(fn ($k) => in_array($k->id_kursi, $terpesan))
                ->take($jumlahKursi)
                ->values();

            if ($kursis->isEmpty() || $kursis->count() < $jumlahKursi) {
                continue;
            }

            $total = $kursis->count() * $jadwal->harga;
            $paid = (bool) rand(0, 1);

            $booking = Booking::create([
                'user_id' => $customer->id,
                'id_jadwal' => $jadwal->id_jadwal,
                'kode_booking' => 'BUS-'.now()->format('Ymd').'-'.Str::upper(Str::random(6)),
                'tanggal_booking' => now()->subDays(rand(1, 5)),
                'total_harga' => $total,
                'status_booking' => $paid ? 'confirmed' : 'pending',
                'status_pembayaran' => $paid ? 'paid' : 'unpaid',
                'payment_method' => $paid ? 'bank_transfer' : null,
                'paid_at' => $paid ? now() : null,
                'expired_at' => now()->addHours(2),
            ]);

            foreach ($kursis as $kursi) {
                BookingSeat::create([
                    'booking_id' => $booking->id,
                    'id_jadwal' => $jadwal->id_jadwal,
                    'id_kursi' => $kursi->id_kursi,
                    'harga' => $jadwal->harga,
                    'nama_penumpang' => $customer->name,
                    'nik' => (string) rand(1000000000000000, 9999999999999999),
                    'no_hp' => $customer->phone,
                    'jenis_kelamin' => 'L',
                    'tanggal_lahir' => now()->subYears(rand(20, 45)),
                    'status_booking' => $booking->status_booking,
                ]);
            }

            if ($paid) {
                Payment::create([
                    'booking_id' => $booking->id,
                    'order_id' => 'MID-'.$booking->kode_booking,
                    'transaction_id' => 'TRX-'.Str::upper(Str::random(10)),
                    'payment_type' => 'bank_transfer',
                    'gross_amount' => $total,
                    'transaction_status' => 'settlement',
                    'payment_status' => 'paid',
                    'paid_at' => $booking->paid_at,
                ]);
            }
        }
    }
}
