<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    protected $primaryKey = 'id_tiket';

    protected $fillable = [
        'kode_tiket',
        'id_jadwal',
        'id_penumpang',
        'id_kursi',
        'nama_pemesan',
        'no_hp_pemesan',
        'status_pembayaran',
    ];

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id_jadwal');
    }

    public function penumpang()
    {
        return $this->belongsTo(Penumpang::class, 'id_penumpang', 'id_penumpang');
    }

    public function kursi()
    {
        return $this->belongsTo(Kursi::class, 'id_kursi', 'id_kursi');
    }
}