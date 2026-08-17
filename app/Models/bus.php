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
        'operator_id',
        'nomor_polisi',
        'kode_bus',
        'nama_bus',
        'kelas',
        'kapasitas',
        'fasilitas',
        'status',
    ];

    protected $casts = [
        'kapasitas' => 'integer',
    ];

    public function operator()
    {
        return $this->belongsTo(Operator::class, 'operator_id', 'id');
    }

    public function kursis()
    {
        return $this->hasMany(Kursi::class, 'id_bus', 'id_bus');
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'id_bus', 'id_bus');
    }

    public function getKelasLabelAttribute()
    {
        return ucfirst($this->kelas);
    }

    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status);
    }
}
