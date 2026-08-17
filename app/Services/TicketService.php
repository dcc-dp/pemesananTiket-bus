<?php

namespace App\Services;

use App\Models\Booking;
use SimpleSoftwareIO\QrCode\Generator;

class TicketService
{
    /**
     * Susun data tiket digital dari booking.
     */
    public function getTicketData(Booking $booking): array
    {
        $jadwal = $booking->jadwal;
        $bus = $jadwal->bus;
        $rute = $jadwal->rute;

        return [
            'kode_booking' => $booking->kode_booking,
            'status' => $booking->status_pembayaran,
            'tanggal_booking' => $booking->tanggal_booking,
            'operator' => $bus->operator->nama_operator ?? '-',
            'bus' => $bus->nama_bus,
            'nomor_polisi' => $bus->nomor_polisi,
            'kelas' => $bus->kelas,
            'fasilitas' => $bus->fasilitas,
            'asal' => $rute->terminalAsal->nama_terminal.' ('.$rute->terminalAsal->kota.')',
            'tujuan' => $rute->terminalTujuan->nama_terminal.' ('.$rute->terminalTujuan->kota.')',
            'tanggal' => $jadwal->tanggal,
            'jam_berangkat' => $jadwal->jam_berangkat,
            'jam_tiba' => $jadwal->jam_tiba ?: $jadwal->jam_berangkat,
            'total_harga' => $booking->total_harga,
            'booking_seats' => $booking->bookingSeats->map(fn ($seat) => [
                'nama_penumpang' => $seat->nama_penumpang,
                'nik' => $seat->nik,
                'no_hp' => $seat->no_hp,
                'kursi' => $seat->kursi->nomor_kursi,
            ])->values(),
        ];
    }

    /**
     * QR code (SVG data URI) berisi kode booking.
     */
    public function qrCode(Booking $booking, int $size = 160): string
    {
        $generator = new Generator;

        $svg = $generator->size($size)->margin(1)->generate($booking->kode_booking);

        return 'data:image/svg+xml;base64,'.base64_encode($svg);
    }
}
