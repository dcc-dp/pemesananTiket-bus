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

    public function getDurasiFormattedAttribute(): string
    {
        if (!$this->estimasi_durasi) {
            return '-';
        }

        $jam = intdiv($this->estimasi_durasi, 60);
        $menit = $this->estimasi_durasi % 60;

        if ($jam > 0 && $menit > 0) {
            return "{$jam} jam {$menit} mnt";
        } elseif ($jam > 0) {
            return "{$jam} jam";
        }

        return "{$menit} mnt";
    }

    public function getDurasiSingkatAttribute(): string
    {
        if (!$this->estimasi_durasi) {
            return '-';
        }

        $jam = intdiv($this->estimasi_durasi, 60);
        $menit = $this->estimasi_durasi % 60;

        if ($jam > 0 && $menit > 0) {
            return "{$jam}j {$menit}m";
        } elseif ($jam > 0) {
            return "{$jam}j";
        }

        return "{$menit}m";
    }
}
