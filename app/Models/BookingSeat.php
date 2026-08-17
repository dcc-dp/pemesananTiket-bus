<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingSeat extends Model
{
    use HasFactory;

    protected $table = 'booking_seats';

    protected $fillable = [
        'booking_id',
        'id_jadwal',
        'id_kursi',
        'harga',
        'nama_penumpang',
        'nik',
        'no_hp',
        'jenis_kelamin',
        'tanggal_lahir',
        'status_booking',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'harga' => 'integer',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id_jadwal');
    }

    public function kursi()
    {
        return $this->belongsTo(Kursi::class, 'id_kursi', 'id_kursi');
    }

    public function getStatusBookingLabelAttribute()
    {
        return ucfirst($this->status_booking);
    }
}
