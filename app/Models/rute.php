<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rute extends Model
{
    use HasFactory;

    protected $table = 'rutes';

    protected $primaryKey = 'id_rute';

    protected $fillable = [
        'kota_asal',
        'kota_tujuan',
        'id_terminal',
    ];

    public function terminal()
    {
        return $this->belongsTo(Terminal::class, 'id_terminal', 'id_terminal');
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'id_rute', 'id_rute');
    }
}