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
        'kota',
    ];

    public function rutes()
    {
        return $this->hasMany(Rute::class, 'id_terminal', 'id_terminal');
    }
}