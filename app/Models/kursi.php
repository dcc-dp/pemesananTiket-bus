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

    /**
     * Hitung tarif efektif kursi berdasarkan aturan prioritas:
     * 1. Tarif khusus per kursi (jika diisi dan > 0)
     * 2. Tarif default dari jadwal keberangkatan
     */
    public function getTarif(?Jadwal $jadwal = null): int
    {
        if ($this->harga !== null && (int) $this->harga > 0) {
            return (int) $this->harga;
        }

        if ($jadwal && (int) $jadwal->harga > 0) {
            return (int) $jadwal->harga;
        }

        $latestJadwal = Jadwal::where('id_bus', $this->id_bus)
            ->orderByDesc('tanggal')
            ->orderByDesc('jam_berangkat')
            ->first();

        if ($latestJadwal && (int) $latestJadwal->harga > 0) {
            return (int) $latestJadwal->harga;
        }

        $anyJadwal = Jadwal::orderByDesc('tanggal')->orderByDesc('jam_berangkat')->first();

        return $anyJadwal ? (int) $anyJadwal->harga : 0;
    }

    /**
     * Dapatkan label kelas kursi (fallback ke kelas bus jika belum diatur)
     */
    public function getKelasEffectiveAttribute(): string
    {
        return !empty($this->kelas) ? $this->kelas : ($this->bus?->kelas ?? 'ekonomi');
    }

    /**
     * Cek apakah kursi memiliki tarif khusus
     */
    public function getHasTarifKhususAttribute(): bool
    {
        return $this->harga !== null && (int) $this->harga > 0;
    }
}
