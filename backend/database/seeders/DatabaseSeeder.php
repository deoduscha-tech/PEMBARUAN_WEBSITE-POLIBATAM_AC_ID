<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the admin workspace account and the starter news set.
     */
    public function run(): void
    {
        // ---------------------------------------------------------
        // Admin workspace account
        //   username : admin
        //   password : admin123
        // ---------------------------------------------------------
        User::updateOrCreate(
            ['email' => 'admin'],
            [
                'name' => 'admin',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ],
        );

        // ---------------------------------------------------------
        // Starter news, mirroring the live P2M content
        // ---------------------------------------------------------
        $posts = [
            [
                'title' => 'Pengumuman Hasil Seleksi Penelitian dan Pengabdian kepada Masyarakat Politeknik Negeri Batam TA 2026',
                'category' => 'Informasi',
                'image' => '/images/Pengumuman-Penerima-Bantuan-Dana-Penelitian-dan-Pengabdian-Masyarakat-Usulan-Baru-bagi-Perguruan-Tinggi-Pengelola-Program-Studi-Pendidikan-Tinggi-Vokasi-Tahun-Anggaran-2023-2.png',
                'published_at' => '2026-06-15 09:00:00',
                'is_featured' => true,
                'views' => 1874,
                'excerpt' => 'Pusat Penelitian dan Pengabdian Masyarakat (P3M) Politeknik Negeri Batam mengumumkan daftar penerima pendanaan Penelitian dan Pengabdian kepada Masyarakat TA 2026.',
                'body' => '<p>Pusat Penelitian dan Pengabdian Masyarakat (P3M) Politeknik Negeri Batam dengan ini mengumumkan hasil seleksi proposal Penelitian dan Pengabdian kepada Masyarakat Tahun Anggaran 2026.</p><p>Pengumuman ini disampaikan berdasarkan hasil penilaian reviewer terhadap kelayakan substansi, kesesuaian roadmap, serta ketersediaan anggaran pada masing-masing skema.</p><h3>Ketentuan bagi penerima pendanaan</h3><ol><li>Penerima wajib menyampaikan surat pernyataan kesediaan pelaksanaan kegiatan.</li><li>Kontrak pelaksanaan ditandatangani sesuai jadwal yang akan diinformasikan kemudian.</li><li>Laporan kemajuan wajib disampaikan pada pertengahan periode pelaksanaan.</li><li>Luaran wajib mengikuti ketentuan yang tercantum pada buku panduan 2026.</li></ol><p>Untuk daftar nama lengkap penerima pendanaan, silakan mengunduh lampiran pengumuman pada tautan yang tersedia di halaman ini.</p>',
            ],
            [
                'title' => 'Panduan Penelitian dan Pengabdian kepada Masyarakat Tahun 2026',
                'category' => 'Informasi',
                'image' => '/images/BUKU-PANDUAN.jpg',
                'published_at' => '2026-04-29 09:00:00',
                'is_featured' => true,
                'views' => 1420,
                'excerpt' => 'Pada pengusulan penelitian dan Pengabdian kepada Masyarakat tahun 2026, Pusat Penelitian dan Pengabdian kepada Masyarakat Politeknik Negeri Batam meluncurkan buku panduan pengusulan penelitian.',
                'body' => '<p>Dalam rangka pengusulan Penelitian dan Pengabdian kepada Masyarakat Tahun 2026, P3M Politeknik Negeri Batam menerbitkan buku panduan sebagai acuan utama bagi seluruh dosen dan tenaga kependidikan.</p><h3>Ruang lingkup panduan</h3><ul><li>Skema dan kriteria kelayakan pengusulan.</li><li>Tahapan serta jadwal penerimaan proposal.</li><li>Format dokumen dan sistematika proposal.</li><li>Ketentuan luaran dan pelaporan.</li></ul><p>Buku panduan ini diharapkan dapat menyelaraskan kualitas usulan dengan standar penilaian nasional serta tidak menimbulkan multitafsir pada proses seleksi.</p>',
            ],
            [
                'title' => 'P3M Polibatam Gelar Expert Talk Series #1: Strategi Publikasi Artikel pada Jurnal Q1 (PASTI Q1)',
                'category' => 'Kegiatan',
                'image' => '/images/111-1.png',
                'published_at' => '2026-04-20 09:00:00',
                'is_featured' => true,
                'views' => 963,
                'excerpt' => 'Batam, 16 April 2026 - Politeknik Negeri Batam melalui kegiatan Expert Talk Series #1 sukses menyelenggarakan webinar bertajuk "Strategi Publikasi Artikel pada Jurnal Q1 (PASTI Q1)".',
                'body' => '<p>Politeknik Negeri Batam melalui P3M menyelenggarakan Expert Talk Series #1 dengan tema "Strategi Publikasi Artikel pada Jurnal Q1 (PASTI Q1)".</p><p>Kegiatan ini dihadiri oleh dosen dan peneliti dari berbagai jurusan, dengan menghadirkan narasumber yang berpengalaman dalam publikasi bereputasi.</p><h3>Materi yang dibahas</h3><ul><li>Menentukan topik yang bernilai kebaruan tinggi.</li><li>Memetakan jurnal target sesuai lingkup penelitian.</li><li>Menyiapkan naskah agar lolos desk review.</li><li>Menangani catatan reviewer secara sistematis.</li></ul><p>Kegiatan serupa akan dilanjutkan secara berkala untuk memperkuat budaya riset dan publikasi di lingkungan Polibatam.</p>',
            ],
            [
                'title' => 'Pengumuman Penerima Pendanaan Program BIMA, Inovasi Seni Nusantara, Hilirisasi Riset Prioritas, dan SEMESTA Tahun Anggaran 2026',
                'category' => 'Informasi',
                'image' => '/images/1.jpg',
                'published_at' => '2026-04-10 09:00:00',
                'is_featured' => false,
                'views' => 1188,
                'excerpt' => 'P3M Politeknik Negeri Batam mengumumkan penerima pendanaan Program Penelitian dan Pengabdian kepada Masyarakat (BIMA), Hilirisasi Riset Prioritas, dan SEMESTA Tahun Anggaran 2026.',
                'body' => '<p>Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) Politeknik Negeri Batam mengumumkan penerima pendanaan program-program sebagai berikut untuk Tahun Anggaran 2026:</p><ol><li>Program Penelitian dan Pengabdian kepada Masyarakat (BIMA)</li><li>Program Inovasi Seni Nusantara (BIMA)</li><li>Program Hilirisasi Riset Prioritas (HILIRISET)</li><li>Program SEMESTA</li></ol><p>Seluruh penerima diharapkan melengkapi dokumen administrasi sesuai ketentuan yang berlaku sebelum pencairan dana dilaksanakan.</p>',
            ],
            [
                'title' => 'Pembentukan dan Pengangkatan Ketua Pusat Kajian (PK) dan Center Of Excellence (CoE) Politeknik Negeri Batam Tahun 2026',
                'category' => 'Informasi',
                'image' => '/images/1.jpg',
                'published_at' => '2026-02-12 09:00:00',
                'is_featured' => false,
                'views' => 742,
                'excerpt' => 'Politeknik Negeri Batam menetapkan Pembentukan dan Pengangkatan Ketua Pusat Kajian (PK) serta Center Of Excellence (CoE) Politeknik Negeri Batam Tahun 2026.',
                'body' => '<p>Sebagai upaya penguatan ekosistem penelitian dan pengabdian kepada masyarakat, Politeknik Negeri Batam menetapkan pembentukan dan pengangkatan Ketua Pusat Kajian (PK) serta Center of Excellence (CoE).</p><h3>Tujuan pembentukan</h3><ul><li>Mengelompokkan kepakaran dosen sesuai bidang unggulan.</li><li>Mendorong riset yang selaras dengan kebutuhan industri.</li><li>Memperkuat kolaborasi lintas jurusan dan mitra strategis.</li></ul><p>Diharapkan struktur baru ini mempercepat hilirisasi hasil riset serta meningkatkan kontribusi institusi bagi masyarakat dan dunia usaha.</p>',
            ],
        ];

        foreach ($posts as $post) {
            $slug = Post::makeSlug($post['title']);

            Post::updateOrCreate(
                ['slug' => $slug],
                $post + [
                    'slug' => $slug,
                    'author' => 'P3M',
                    'is_published' => true,
                ],
            );
        }
    }
}
