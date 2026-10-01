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
        'kelas',
        'harga',
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

    public function getPosisiAttribute($value)
    {
        $col = strtoupper(substr((string) $this->nomor_kursi, -1));
        if (in_array($col, ['A', 'D'])) {
            return 'Jendela';
        }
        if (in_array($col, ['B', 'C'])) {
            return 'Lorong';
        }

        return !empty($value) ? ucfirst(strtolower($value)) : 'Jendela';
    }

    public function setPosisiAttribute($value)
    {
        if (empty($value)) {
            $col = strtoupper(substr((string) $this->nomor_kursi, -1));
            $value = in_array($col, ['A', 'D']) ? 'jendela' : (in_array($col, ['B', 'C']) ? 'lorong' : 'jendela');
        }
        $this->attributes['posisi'] = strtolower((string) $value);
    }
}
