<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisUsaha;

class JenisUsahaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisSurat = [
            [
                'nama_jenis' => 'Surat Keputusan (SK)',
                'deskripsi' => 'Surat yang berisi penetapan atau keputusan resmi dari pejabat yang berwenang.'
            ],
            [
                'nama_jenis' => 'Surat Tugas',
                'deskripsi' => 'Surat yang memberikan penugasan kepada pegawai untuk melaksanakan suatu kegiatan.'
            ],
            [
                'nama_jenis' => 'Surat Undangan',
                'deskripsi' => 'Surat yang digunakan untuk mengundang pihak tertentu dalam suatu kegiatan atau rapat.'
            ],
            [
                'nama_jenis' => 'Surat Edaran',
                'deskripsi' => 'Surat yang berisi pemberitahuan atau informasi resmi kepada seluruh unit kerja.'
            ],
            [
                'nama_jenis' => 'Nota Dinas',
                'deskripsi' => 'Surat komunikasi internal antar pejabat atau unit kerja.'
            ],
            [
                'nama_jenis' => 'Memorandum',
                'deskripsi' => 'Dokumen yang digunakan untuk menyampaikan informasi atau arahan secara internal.'
            ],
            [
                'nama_jenis' => 'Surat Permohonan',
                'deskripsi' => 'Surat yang digunakan untuk mengajukan permintaan atau usulan tertentu.'
            ],
            [
                'nama_jenis' => 'Surat Persetujuan',
                'deskripsi' => 'Surat yang menyatakan persetujuan terhadap suatu usulan atau kegiatan.'
            ],
            [
                'nama_jenis' => 'Surat Keterangan',
                'deskripsi' => 'Surat yang menerangkan suatu keadaan atau informasi tertentu.'
            ],
            [
                'nama_jenis' => 'Berita Acara',
                'deskripsi' => 'Dokumen yang mencatat hasil pelaksanaan kegiatan, rapat, atau pemeriksaan.'
            ],
            [
                'nama_jenis' => 'Laporan Kegiatan',
                'deskripsi' => 'Dokumen yang berisi laporan hasil pelaksanaan suatu kegiatan.'
            ],
            [
                'nama_jenis' => 'Surat Perintah',
                'deskripsi' => 'Surat resmi yang berisi perintah untuk melaksanakan tugas tertentu.'
            ],
            [
                'nama_jenis' => 'Surat Masuk',
                'deskripsi' => 'Dokumen surat yang diterima dari instansi atau pihak lain.'
            ],
            [
                'nama_jenis' => 'Surat Keluar',
                'deskripsi' => 'Dokumen surat yang diterbitkan oleh instansi kepada pihak lain.'
            ],
            [
                'nama_jenis' => 'Dokumen Pendukung',
                'deskripsi' => 'Dokumen pendukung yang dilampirkan dalam proses administrasi atau Rencana Aksi Perubahan.'
            ],
        ];

        foreach ($jenisSurat as $jenis) {
            JenisUsaha::create($jenis);
        }
    }
}