<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembinaan extends Model
{
    use HasFactory;
    protected $fillable = ['judul_pembinaan', 'tanggal', 'deskripsi', 'hasil'];


}
