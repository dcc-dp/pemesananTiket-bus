<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    protected $fillable = [
        'user_id',
        'id_jadwal',
        'kode_booking',
        'tanggal_booking',
        'total_harga',
        'status_booking',
        'status_pembayaran',
        'payment_method',
        'paid_at',
        'expired_at',
    ];

    protected $casts = [
        'tanggal_booking' => 'datetime',
        'paid_at' => 'datetime',
        'expired_at' => 'datetime',
        'total_harga' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id_jadwal');
    }

    public function bookingSeats()
    {
        return $this->hasMany(BookingSeat::class, 'booking_id', 'id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'booking_id', 'id');
    }

    public function isActive()
    {
        return in_array($this->status_booking, ['pending', 'confirmed', 'completed']);
    }

    public function getStatusBookingLabelAttribute()
    {
        return ucfirst($this->status_booking);
    }

    public function getStatusPembayaranLabelAttribute()
    {
        return ucfirst($this->status_pembayaran);
    }
}
