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
}
