<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dokumen;

class DokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dokumen = [

            [
                'kategori_id' => 1,
                'user_id' => 1,
                'nomor_dokumen' => 'DOC-001',
                'judul' => 'Surat Keputusan Kepala Kantor',
                'deskripsi' => 'Dokumen keputusan kepala kantor.',
                'file_path' => 'dokumen/DOC-001.pdf',
                'tanggal_dokumen' => '2026-01-05',
                'versi' => '1.0',
                'status' => 'approved',
            ],

            [
                'kategori_id' => 2,
                'user_id' => 2,
                'nomor_dokumen' => 'DOC-002',
                'judul' => 'Surat Tugas Pegawai',
                'deskripsi' => 'Surat tugas kegiatan dinas.',
                'file_path' => 'dokumen/DOC-001.pdf',
                'tanggal_dokumen' => '2026-01-10',
                'versi' => '1.0',
                'status' => 'approved',
            ],

            [
                'kategori_id' => 3,
                'user_id' => 3,
                'nomor_dokumen' => 'DOC-003',
                'judul' => 'Laporan Bulanan Januari',
                'deskripsi' => 'Laporan kegiatan bulan Januari.',
                'file_path' => 'dokumen/DOC-001.pdf',
                'tanggal_dokumen' => '2026-01-31',
                'versi' => '1.0',
                'status' => 'review',
            ],

            [
                'kategori_id' => 4,
                'user_id' => 4,
                'nomor_dokumen' => 'DOC-004',
                'judul' => 'Laporan Keuangan Januari',
                'deskripsi' => 'Laporan keuangan bulanan.',
                'file_path' => 'dokumen/DOC-001.pdf',
                'tanggal_dokumen' => '2026-01-31',
                'versi' => '1.0',
                'status' => 'approved',
            ],

            [
                'kategori_id' => 5,
                'user_id' => 1,
                'nomor_dokumen' => 'DOC-005',
                'judul' => 'Berita Acara Rapat',
                'deskripsi' => 'Hasil rapat koordinasi.',
                'file_path' => 'dokumen/DOC-001.pdf',
                'tanggal_dokumen' => '2026-02-03',
                'versi' => '1.0',
                'status' => 'draft',
            ],

            [
                'kategori_id' => 6,
                'user_id' => 2,
                'nomor_dokumen' => 'DOC-006',
                'judul' => 'SOP Pelayanan Paspor',
                'deskripsi' => 'Standar Operasional Prosedur.',
                'file_path' => 'dokumen/DOC-001.pdf',
                'tanggal_dokumen' => '2026-02-06',
                'versi' => '2.0',
                'status' => 'approved',
            ],

            [
                'kategori_id' => 7,
                'user_id' => 3,
                'nomor_dokumen' => 'DOC-007',
                'judul' => 'SOP Kepegawaian',
                'deskripsi' => 'Dokumen SOP Kepegawaian.',
                'file_path' => 'dokumen/DOC-001.pdf',
                'tanggal_dokumen' => '2026-02-10',
                'versi' => '1.1',
                'status' => 'review',
            ],

            [
                'kategori_id' => 8,
                'user_id' => 4,
                'nomor_dokumen' => 'DOC-008',
                'judul' => 'Surat Edaran Internal',
                'deskripsi' => 'Edaran kepada seluruh pegawai.',
                'file_path' => 'dokumen/DOC-001.pdf',
                'tanggal_dokumen' => '2026-02-15',
                'versi' => '1.0',
                'status' => 'approved',
            ],

            [
                'kategori_id' => 9,
                'user_id' => 1,
                'nomor_dokumen' => 'DOC-009',
                'judul' => 'Notulen Rapat',
                'deskripsi' => 'Notulen rapat mingguan.',
                'file_path' => 'dokumen/DOC-001.pdf',
                'tanggal_dokumen' => '2026-02-20',
                'versi' => '1.0',
                'status' => 'draft',
            ],

            [
                'kategori_id' => 10,
                'user_id' => 2,
                'nomor_dokumen' => 'DOC-010',
                'judul' => 'Surat Masuk Kementerian',
                'deskripsi' => 'Dokumen surat masuk.',
                'file_path' => 'dokumen/DOC-001.pdf',
                'tanggal_dokumen' => '2026-02-25',
                'versi' => '1.0',
                'status' => 'approved',
            ],

        ];

        // Membuat data DOC-011 sampai DOC-030
        for ($i = 11; $i <= 30; $i++) {

            $dokumen[] = [

                'kategori_id' => rand(1,10),
                'user_id' => rand(1,4),
                'nomor_dokumen' => 'DOC-' . str_pad($i,3,'0',STR_PAD_LEFT),
                'judul' => 'Dokumen Administrasi '.$i,
                'deskripsi' => 'Contoh dokumen administrasi nomor '.$i,
                'file_path' => 'dokumen/DOC-001.pdf',
                'tanggal_dokumen' => now()->subDays(rand(1,180))->format('Y-m-d'),
                'versi' => rand(1,3).'.'.rand(0,9),
                'status' => collect([
                    'draft',
                    'review',
                    'approved',
                    'obsolete'
                ])->random(),

            ];

        }

        foreach ($dokumen as $data) {

            Dokumen::create($data);

        }
    }
}