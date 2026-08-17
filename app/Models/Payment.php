<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'booking_id',
        'order_id',
        'transaction_id',
        'payment_type',
        'gross_amount',
        'transaction_status',
        'payment_status',
        'paid_at',
        'raw_response',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'gross_amount' => 'integer',
        'raw_response' => 'array',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    public function getPaymentStatusLabelAttribute()
    {
        return ucfirst($this->payment_status);
    }
}
