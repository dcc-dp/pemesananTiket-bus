<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penumpang extends Model
{
    use HasFactory;

    protected $table = 'penumpangs';

    protected $primaryKey = 'id_penumpang';

    protected $fillable = [
        'nama_penumpang',
        'no_kp',
        'email',
        'jenis_kelamin',
    ];

    public function tikets()
    {
        return $this->hasMany(Tiket::class, 'id_penumpang', 'id_penumpang');
    }
}