<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_id',
        'user_id',
        'nomor_dokumen',
        'judul',
        'deskripsi',
        'file_path',
        'tanggal_dokumen',
        'versi',
        'status'
    ];

    protected $casts = [
        'tanggal_dokumen' => 'date',
    ];

    /**
     * Relasi ke kategori dokumen
     */
    public function kategori()
    {
        return $this->belongsTo(JenisUsaha::class);
    }


    /**
     * Relasi ke user pengunggah
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}