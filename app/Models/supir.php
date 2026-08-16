<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supir extends Model
{
    use HasFactory;

    protected $table = 'supirs';

    protected $primaryKey = 'id_supir';

    protected $fillable = [
        'nama_supir',
        'notelp',
    ];

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'id_supir', 'id_supir');
    }
}