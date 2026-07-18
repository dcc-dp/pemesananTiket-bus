<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pembinaan;

class KegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [

            [
                'judul_pembinaan' => 'Sosialisasi Digital Marketing',
                'tanggal' => '2026-01-15',
                'deskripsi' => 'Pelatihan pemasaran digital melalui media sosial.',
                'hasil' => 'UMKM memahami strategi promosi digital.',
            ],

            [
                'judul_pembinaan' => 'Pelatihan Pengemasan Produk',
                'tanggal' => '2026-01-22',
                'deskripsi' => 'Peningkatan kualitas kemasan produk UMKM.',
                'hasil' => 'Kemasan produk menjadi lebih menarik.',
            ],

            [
                'judul_pembinaan' => 'Pelatihan Manajemen Keuangan',
                'tanggal' => '2026-02-03',
                'deskripsi' => 'Pencatatan keuangan sederhana bagi UMKM.',
                'hasil' => 'Pelaku UMKM mulai membuat laporan keuangan.',
            ],

            [
                'judul_pembinaan' => 'Pelatihan Branding Produk',
                'tanggal' => '2026-02-10',
                'deskripsi' => 'Membangun identitas dan merek produk.',
                'hasil' => 'Peserta memahami pentingnya branding.',
            ],

            [
                'judul_pembinaan' => 'Pelatihan Sertifikasi Halal',
                'tanggal' => '2026-02-18',
                'deskripsi' => 'Pendampingan proses pengajuan sertifikat halal.',
                'hasil' => 'UMKM siap mengajukan sertifikasi halal.',
            ],

            [
                'judul_pembinaan' => 'Pelatihan Legalitas Usaha',
                'tanggal' => '2026-03-01',
                'deskripsi' => 'Pembuatan NIB dan legalitas usaha.',
                'hasil' => 'Peserta telah memiliki pemahaman legalitas usaha.',
            ],

            [
                'judul_pembinaan' => 'Pelatihan Fotografi Produk',
                'tanggal' => '2026-03-12',
                'deskripsi' => 'Teknik pengambilan foto produk menggunakan smartphone.',
                'hasil' => 'Foto produk lebih menarik untuk promosi.',
            ],

            [
                'judul_pembinaan' => 'Pelatihan Marketplace',
                'tanggal' => '2026-03-20',
                'deskripsi' => 'Pemanfaatan marketplace untuk penjualan online.',
                'hasil' => 'Peserta berhasil membuat toko online.',
            ],

            [
                'judul_pembinaan' => 'Pelatihan Pelayanan Konsumen',
                'tanggal' => '2026-04-05',
                'deskripsi' => 'Meningkatkan kualitas pelayanan kepada pelanggan.',
                'hasil' => 'Pelayanan pelanggan menjadi lebih baik.',
            ],

            [
                'judul_pembinaan' => 'Evaluasi Program Pembinaan',
                'tanggal' => '2026-04-18',
                'deskripsi' => 'Evaluasi hasil pembinaan UMKM selama triwulan pertama.',
                'hasil' => 'Sebagian besar UMKM mengalami peningkatan kapasitas usaha.',
            ],

        ];

        foreach ($datas as $data) {
            Pembinaan::create($data);
        }
    }
}