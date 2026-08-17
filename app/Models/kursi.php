<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kursi extends Model
{
    use HasFactory;

    protected $table = 'kursis';

    protected $primaryKey = 'id_kursi';

    protected $fillable = [
        'id_bus',
        'nomor_kursi',
        'posisi',
        'status',
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class, 'id_bus', 'id_bus');
    }

    public function bookingSeats()
    {
        return $this->hasMany(BookingSeat::class, 'id_kursi', 'id_kursi');
    }

    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status);
    }
}
