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
        'id_supir',
        'tanggal',
        'jam_berangkat',
        'harga',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_berangkat' => 'datetime:H:i',
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

    public function supir()
    {
        return $this->belongsTo(Supir::class, 'id_supir', 'id_supir');
    }

    public function tikets()
    {
        return $this->hasMany(Tiket::class, 'id_jadwal', 'id_jadwal');
    }
}