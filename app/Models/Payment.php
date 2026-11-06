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

    public function getMetodeLabelAttribute(): string
    {
        $raw = $this->raw_response ?? [];
        $type = $this->payment_type ?: ($raw['payment_type'] ?? null);

        if (empty($type)) {
            $method = $this->booking?->payment_method;
            if ($method && $method !== 'midtrans') {
                return ucfirst($method);
            }
            return '-';
        }

        $typeLower = strtolower((string) $type);
        $issuer = strtolower((string) ($raw['issuer'] ?? ($raw['acquirer'] ?? '')));

        if ($typeLower === 'gopay' || $issuer === 'gopay') {
            return 'GoPay';
        }

        if ($typeLower === 'shopeepay' || $issuer === 'airpay shopee' || $issuer === 'shopeepay') {
            return 'ShopeePay';
        }

        if ($typeLower === 'qris') {
            if (!empty($issuer)) {
                return strtoupper($issuer) . ' (QRIS)';
            }
            return 'QRIS';
        }

        if ($typeLower === 'bank_transfer') {
            $bank = '';
            if (!empty($raw['va_numbers'][0]['bank'])) {
                $bank = strtoupper($raw['va_numbers'][0]['bank']);
            } elseif (!empty($raw['permata_va_number'])) {
                $bank = 'Permata';
            }
            return $bank ? "Transfer {$bank}" : 'Transfer Bank';
        }

        if (str_starts_with($typeLower, 'va_')) {
            $bank = strtoupper(substr($typeLower, 3));
            return "Transfer {$bank}";
        }

        if ($typeLower === 'echannel') {
            return 'Mandiri Bill';
        }

        if ($typeLower === 'cstore') {
            $store = ucfirst($raw['store'] ?? 'Convenience Store');
            return $store;
        }

        if ($typeLower === 'credit_card') {
            $bank = !empty($raw['bank']) ? ' (' . strtoupper($raw['bank']) . ')' : '';
            return 'Kartu Kredit' . $bank;
        }

        if ($typeLower === 'cash' || $typeLower === 'tunai' || is_numeric($typeLower)) {
            return 'Cash';
        }

        return ucfirst(str_replace('_', ' ', $type));
    }
}
