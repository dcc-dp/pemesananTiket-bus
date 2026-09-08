<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{
    use HasFactory;

    protected $table = 'terminals';

    protected $primaryKey = 'id_terminal';

    protected $fillable = [
        'nama_terminal',
        'kode_terminal',
        'latitude',
        'longitude',
        'alamat',
        'kota',
        'provinsi',
        'status',
    ];
    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function routesAsal()
    {
        return $this->hasMany(Rute::class, 'terminal_asal_id', 'id_terminal');
    }

    public function routesTujuan()
    {
        return $this->hasMany(Rute::class, 'terminal_tujuan_id', 'id_terminal');
    }

    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status);
    }
}
