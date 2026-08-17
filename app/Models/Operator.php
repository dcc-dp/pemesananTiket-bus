<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    use HasFactory;

    protected $table = 'operators';

    protected $fillable = [
        'nama_operator',
        'kode_operator',
        'alamat',
        'telepon',
        'email',
        'status',
    ];

    public function buses()
    {
        return $this->hasMany(Bus::class, 'operator_id', 'id');
    }

    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status);
    }
}
