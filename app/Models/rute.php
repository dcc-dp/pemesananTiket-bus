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
        'terminal_asal_id',
        'terminal_tujuan_id',
        'jarak',
        'estimasi_durasi',
        'status',
    ];

    protected $casts = [
        'jarak' => 'float',
        'estimasi_durasi' => 'integer',
    ];
    public function terminalAsal()
    {
        return $this->belongsTo(Terminal::class, 'terminal_asal_id', 'id_terminal');
    }

    public function terminalTujuan()
    {
        return $this->belongsTo(Terminal::class, 'terminal_tujuan_id', 'id_terminal');
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'id_rute', 'id_rute');
    }

    public function getNamaRuteAttribute()
    {
        $asal = $this->terminalAsal->kota ?? '-';
        $tujuan = $this->terminalTujuan->kota ?? '-';

        return $asal . ' → ' . $tujuan;
    }

    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status);
    }
}
