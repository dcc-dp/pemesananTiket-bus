<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwals';

    protected $primaryKey = 'id_jadwal';

    protected $fillable = [
        'id_bus',
        'id_rute',
        'tanggal',
        'jam_berangkat',
        'jam_tiba',
        'harga',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_berangkat' => 'datetime:H:i',
        'jam_tiba' => 'datetime:H:i',
        'harga' => 'integer',
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class, 'id_bus', 'id_bus');
    }

    public function rute()
    {
        return $this->belongsTo(Rute::class, 'id_rute', 'id_rute');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_jadwal', 'id_jadwal');
    }

    public function bookingSeats()
    {
        return $this->hasMany(BookingSeat::class, 'id_jadwal', 'id_jadwal');
    }

    public function kursiTerpesan(): array
    {
        return $this->bookingSeats()
            ->whereIn('status_booking', ['pending', 'confirmed', 'completed'])
            ->pluck('id_kursi')
            ->toArray();
    }

    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status);
    }

    public function getJamTibaFormattedAttribute(): string
    {
        if ($this->jam_tiba) {
            return \Carbon\Carbon::parse($this->jam_tiba)->format('H:i');
        }

        if ($this->jam_berangkat && $this->rute && $this->rute->estimasi_durasi) {
            return \Carbon\Carbon::parse($this->jam_berangkat)->addMinutes($this->rute->estimasi_durasi)->format('H:i');
        }

        return $this->jam_berangkat ? \Carbon\Carbon::parse($this->jam_berangkat)->format('H:i') : '-';
    }

    public function getIsNextDayAttribute(): bool
    {
        if (!$this->jam_berangkat) {
            return false;
        }

        $berangkat = \Carbon\Carbon::parse($this->jam_berangkat);
        $durasiMenit = $this->rute->estimasi_durasi ?? null;

        if ($durasiMenit !== null && $durasiMenit > 0) {
            $tiba = (clone $berangkat)->addMinutes($durasiMenit);
            return $tiba->format('Y-m-d') !== $berangkat->format('Y-m-d');
        }

        if ($this->jam_tiba) {
            $tiba = \Carbon\Carbon::parse($this->jam_tiba);
            return $tiba->format('H:i') < $berangkat->format('H:i');
        }

        return false;
    }
}
