<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $table = 'buses';

    protected $primaryKey = 'id_bus';

    protected $fillable = [
        'nama_po',
        'plat_nomor',
        'kapasitas',
    ];

    public function kursis()
    {
        return $this->hasMany(Kursi::class, 'id_bus', 'id_bus');
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'id_bus', 'id_bus');
    }
}