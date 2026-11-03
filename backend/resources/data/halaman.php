<?php

/**
 * Konten halaman statis — satu sumber data untuk BOTH front end:
 *   - App\Http\Controllers\Api\HalamanApiController  (API Next.js)
 *   - App\Http\Controllers\PublicPageController      (Blade)
 *
 * Setiap entri :
 *   heading  : judul halaman (h1)
 *   visitors : jumlah pengunjung yang ditampilkan di bawah konten
 *   intro    : paragraf pembuka (array of string, boleh kosong)
 *   sections : daftar blok konten. Tiap blok:
 *                title -> judul blok (boleh null)
 *                paragraphs -> array paragraf (boleh kosong)
 *                list -> array butir daftar (boleh kosong)
 *                hrefs -> array tautan { label, url } (boleh kosong)
 *   charts   : khusus statistik — daftar grafik Datawrapper
 *   documents: daftar dokumen { title, description, href }
 */

$profil = array(
  'heading' => 'PROFIL',
  'visitors' => 17874,
  'intro' => array(
    'Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) Politeknik Negeri Batam merupakan unit yang mengelola, memfasilitasi, serta mengembangkan kegiatan penelitian dan pengabdian kepada masyarakat di lingkungan Polibatam.',
    'Unit ini mendorong terciptanya riset yang berkualitas, publikasi ilmiah yang bereputasi, serta hilirisasi hasil penelitian yang berdampak bagi industri dan masyarakat.',
  ),
  'sections' => array(),
);

$informasi = array(
  'heading' => 'INFORMASI',
  'visitors' => 6589,
  'intro' => array(
    'Informasi terkini seputar penelitian, pengabdian kepada masyarakat, serta kegiatan Pusat P2M Politeknik Negeri Batam.',
  ),
  'sections' => array(),
  'show_posts' => true,
);

$renstra = array(
  'heading' => 'Renstra Penelitian',
  'visitors' => 7044,
  'intro' => array(
    'Rencana Strategis Penelitian (Renstra Penelitian) Institusi merupakan arahan kebijakan dan pengambilan keputusan dalam pengelolaan penelitian institusi dalam jangka waktu tertentu (5 tahun). Sebagai salah satu lembaga pendidikan vokasi yang menjadi garda terdepan dalam pengembangan keilmuan dan pengabdian masyarakat, Renstra Penelitian Politeknik Negeri Batam (Renstra Penelitian PoliBatam) diharapkan dapat berkontribusi tidak hanya kepada masyarakat tapi juga negara dan bangsa Indonesia maupun dunia.',
    'Salah satu bentuk sumbangsih tersebut adalah dengan melakukan kegiatan riset yang hasilnya dapat diabdikan kepada peningkatan secara produktif kesejahteraan dan kemanusiaan masyarakat dan bangsa Indonesia pada umumnya. Berlatar belakang pada keperluan penyelesaian masalah kemanusiaan, perlu dibuat sebuah langkah strategis yang cerdas dan dinamis bagi kegiatan riset di Politeknik Negeri Batam.',
    'Strategi yang dipilih adalah penentuan sebuah program strategis riset yang dilandaskan pada kepakaran yang dimiliki periset Politeknik Negeri Batam. Program strategis riset yang diunggulkan adalah di mana Politeknik Negeri Batam memang unggul (proses bottom up melalui identifikasi kompetensi riil dari track record seorang periset) dan mampu bersaing baik di skala nasional maupun internasional, dengan cara yang cerdas memilih program strategis (jenis riset yang diunggulkan) yang khas pendidikan vokasi.',
  ),
  'sections' => array(
    array(
      'title' => 'Selengkapnya pada Link berikut:',
      'paragraphs' => array(),
      'list' => array(),
      'hrefs' => array(
        array(
          'label' => 'SK PENETAPAN RESNTRA PENELITIAN POLIBATAM 2021-2025',
          'url' => 'https://p2m.polibatam.ac.id/wp-content/uploads/2021/08/568-Penetapan-Renstra-Penelitian-Polibatam-Periode-2021-2025-1.pdf',
        ),
        array(
          'label' => 'RENSTRA PENELITIAN POLIBATAM 2021-2025',
          'url' => 'https://p2m.polibatam.ac.id/wp-content/uploads/2021/08/Renstra-Penelitian-2021-2025.pdf',
        ),
      ),
    ),
  ),
);

$rip = array(
  'heading' => 'RIP Pengabdian',
  'visitors' => 6071,
  'intro' => array(
    'Visi dari Politeknik Negeri Batam (Polibatam) adalah "Menjadi politeknik generasi baru yang bermutu, unggul, adaptif, inovatif dan bermitra erat dengan industri dan masyarakat untuk mendukung Indonesia Maju dan Sejahtera 2045" Guna mendukung Visi tersebut, Politeknik Negeri Batam berusaha untuk mengintegrasikan kegiatan Tridarma yaitu pengajaran, penelitian dan pengabdian kepada masyarakat. Oleh karena itu, untuk mewujudkan visi Polibatam tersebut maka Pusat Penelitian dan Pengabdian Kepada Masyarakat (Pusat P2M), menyusun Rencana Strategis (Renstra) Pengabdian Kepada Masyarakat (PPM) sebagai pedoman dalam pengembangan arah kegiatan pengabdian kepada masyarakat.',
    'Renstra PPM Polibatam disusun berdasarkan Peraturan Menteri Pendidikan dan Kebudayaan nomor 3 tahun 2020 tentang Standar Nasional Pendidikan Tinggi khususnya Bab IV Standar Nasional Pengabdian Kepada Masyarakat. Ruang lingkup Standar Nasional Pengabdian kepada Masyarakat terdiri atas: Standar hasil pengabdian kepada masyarakat; Standar isi pengabdian kepada masyarakat; Standar proses pengabdian kepada masyarakat; Standar penilaian pengabdian kepada masyarakat; Standar pelaksana pengabdian kepada masyarakat; Standar sarana dan prasarana pengabdian kepada masyarakat; Standar pengelolaan pengabdian kepada masyarakat; dan Standar pendanaan dan pembiayaan pengabdian kepada masyarakat. Ke delapan standar PPM ini akan menjadi acuan utama dalam perencanaan, pelaksanaan, dan evaluasi hasil PPM Polibatam.',
  ),
  'sections' => array(
    array(
      'title' => 'Selengkapnya pada Link berikut:',
      'paragraphs' => array(),
      'list' => array(),
      'hrefs' => array(
        array(
          'label' => 'SK PENETAPAN RENCANA INDUK PENGABDIAN MASYARAKAT (RIPPM) POLIBATAM 2021-2025',
          'url' => 'https://p2m.polibatam.ac.id/wp-content/uploads/2021/08/569-Penetapan-Rencana-Induk-Pengabdian-pada-Masyarakat-RIPPM-Politeknik-Negeri-Batam-Periode-2021-2025.pdf',
        ),
        array(
          'label' => 'RIP PENGABDIAN MASYARAKAT POLIBATAM 2021-2025',
          'url' => 'https://p2m.polibatam.ac.id/wp-content/uploads/2021/08/RIP-Pengabdian-Masyarakat-2021-2025.pdf',
        ),
      ),
    ),
  ),
);

$statistik = array(
  'heading' => 'Statistik',
  'visitors' => 2702,
  'intro' => array(),
  'sections' => array(),
  'charts' => array(
    array('key' => 'internal', 'title' => 'Penelitian dan Pengabdian Internal', 'id' => 'R7LDv', 'version' => 3, 'height' => 414, 'width' => 970, 'group' => 'main'),
    array('key' => 'external', 'title' => 'Penelitian dan Pengabdian Eksternal', 'id' => 'T8EQF', 'version' => 2, 'height' => 414, 'width' => 600, 'group' => 'main'),
    array('key' => 'hki', 'title' => 'HKI (Hak Kekayaan Intelektual) Polibatam 2017-2024', 'id' => 'd5xu9', 'version' => 2, 'height' => 361, 'width' => 600, 'group' => 'main'),
    array('key' => 'copyright', 'title' => 'Hak Cipta', 'id' => 'wFoOi', 'version' => 5, 'height' => 361, 'width' => 600, 'group' => 'hki-detail'),
    array('key' => 'patent', 'title' => 'Paten/ Paten Sederhana 2017-2024', 'id' => 'dLDrv', 'version' => 1, 'height' => 361, 'width' => 600, 'group' => 'hki-detail'),
    array('key' => 'industrialDesign', 'title' => 'Desain Industri', 'id' => 'fkF82', 'version' => 1, 'height' => 361, 'width' => 600, 'group' => 'hki-detail'),
    array('key' => 'lecturer', 'title' => 'Jabatan Fungsional Dosen Polibatam (24 Feb 2025)', 'id' => 'PN2h5', 'version' => 1, 'height' => 237, 'width' => 600, 'group' => 'main'),
    array('key' => 'electrical', 'title' => 'Jabatan Fungsional Dosen Teknik Elektro', 'id' => 'F77g5', 'version' => 2, 'height' => 237, 'width' => 600, 'group' => 'prodi'),
    array('key' => 'informatics', 'title' => 'Jabatan Fungsional Dosen Teknik Informatika', 'id' => 'NOaHv', 'version' => 1, 'height' => 237, 'width' => 600, 'group' => 'prodi'),
    array('key' => 'business', 'title' => 'Jabatan Fungsional Dosen Manajemen Bisnis', 'id' => '4reGJ', 'version' => 1, 'height' => 237, 'width' => 600, 'group' => 'prodi'),
    array('key' => 'mechanical', 'title' => 'Jabatan Fungsional Dosen Teknik Mesin', 'id' => 'F4ffL', 'version' => 1, 'height' => 237, 'width' => 600, 'group' => 'prodi'),
  ),
);

$penelitian = array(
  'heading' => 'PENELITIAN',
  'visitors' => null,
  'intro' => array(
    'Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) Politeknik Negeri Batam mengelola kegiatan penelitian sebagai bagian dari pelaksanaan Tri Dharma Perguruan Tinggi. Penelitian diarahkan pada pengembangan ilmu pengetahuan dan teknologi yang aplikatif serta selaras dengan kebutuhan industri dan masyarakat.',
    'Melalui kolaborasi dengan dosen, pusat kajian, pusat unggulan, dunia usaha, dan dunia industri, P3M mendorong lahirnya riset yang inovatif, berkualitas, dan memberikan manfaat nyata bagi pembangunan nasional.',
  ),
  'sections' => array(),
  'schemes' => array(
    array('title' => 'Penelitian Dasar', 'description' => 'Penelitian yang berorientasi pada pengembangan teori, konsep, dan metode keilmuan sebagai fondasi pengembangan riset lanjutan.', 'focus' => array('Pengembangan konsep dan metode baru', 'Kajian keilmuan dasar bidang vokasi', 'Publikasi pada jurnal bereputasi')),
    array('title' => 'Penelitian Terapan', 'description' => 'Penelitian yang diarahkan pada penerapan ilmu pengetahuan untuk menyelesaikan permasalahan nyata di industri dan masyarakat.', 'focus' => array('Solusi teknologi tepat guna', 'Prototipe dan purwarupa produk', 'Hilirisasi hasil riset ke industri')),
    array('title' => 'Penelitian Pengembangan', 'description' => 'Penelitian yang mengembangkan produk, teknologi, atau sistem yang sudah ada agar lebih efektif, efisien, dan siap digunakan.', 'focus' => array('Pengembangan produk dan sistem', 'Uji coba dan evaluasi teknologi', 'Dukungan komersialisasi hasil riset')),
    array('title' => 'Penelitian Kerja Sama', 'description' => 'Penelitian kolaboratif antara Polibatam dengan perguruan tinggi lain, pemerintah, maupun mitra industri.', 'focus' => array('Kemitraan lintas institusi', 'Riset sesuai kebutuhan industri', 'Pendanaan bersama mitra')),
    array('title' => 'Penelitian Berbasis PBL', 'description' => 'Penelitian yang terintegrasi dengan Project Based Learning, melibatkan mahasiswa langsung dalam penyelesaian proyek nyata.', 'focus' => array('Mahasiswa terlibat dalam riset', 'Luaran bermanfaat bagi industri', 'Penguatan kompetensi lulusan')),
    array('title' => 'Publikasi & Diseminasi', 'description' => 'Dukungan penyebarluasan hasil penelitian melalui publikasi ilmiah, seminar, dan konferensi nasional maupun internasional.', 'focus' => array('Pendampingan penulisan artikel ilmiah', 'Dukungan biaya publikasi', 'Dokumentasi luaran riset')),
  ),
  'documents' => array(
    array('title' => 'Buku Panduan Penelitian dan Pengabdian 2026', 'description' => 'Acuan utama pengusulan proposal penelitian dan pengabdian tahun 2026.', 'href' => null),
    array('title' => 'Format Proposal Penelitian', 'description' => 'Template penulisan proposal penelitian sesuai ketentuan P3M.', 'href' => null),
    array('title' => 'Format Laporan Kemajuan', 'description' => 'Template pelaporan kemajuan kegiatan penelitian.', 'href' => null),
  ),
);

$pengabdian = $penelitian;
$pengabdian['heading'] = 'PENGABDIAN';
$pengabdian['intro'] = array(
  'Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) Politeknik Negeri Batam mengelola kegiatan pengabdian kepada masyarakat sebagai wujud penerapan ilmu pengetahuan dan teknologi bagi kesejahteraan masyarakat.',
  'Kegiatan pengabdian diarahkan pada penyelesaian permasalahan nyata di masyarakat dan industri melalui kolaborasi dengan pemerintah daerah, dunia usaha, dunia industri, serta mitra strategis lainnya.',
);
$pengabdian['schemes'] = array(
  array('title' => 'Pengabdian Berbasis Wilayah', 'description' => 'Pengabdian yang menyasar potensi dan permasalahan satu kawasan, melibatkan masyarakat secara langsung.', 'focus' => array('Pendampingan UMKM', 'Penguatan desa wisata', 'Peningkatan literasi teknologi')),
  array('title' => 'Pengabdian Berbasis Produk', 'description' => 'Pengabdian yang menghasilkan produk atau teknologi tepat guna untuk masyarakat sasaran.', 'focus' => array('Alat tepat guna', 'Sistem informasi desa', 'Sertifikasi produk UMKM')),
  array('title' => 'Pengabdian Berbasis Riset', 'description' => 'Pengabdian yang bersumber dari hasil penelitian dosen dan mahasiswa.', 'focus' => array('Hilirisasi hasil riset', 'Implementasi prototipe', 'Publikasi luaran abdimas')),
  array('title' => 'Pengabdian Kerja Sama', 'description' => 'Pengabdian kolaboratif dengan pemerintah daerah, industri, dan perguruan tinggi lain.', 'focus' => array('Kemitraan lintas institusi', 'Program CSR industri', 'Pendanaan bersama mitra')),
  array('title' => 'Pengabdian Berbasis PBL', 'description' => 'Pengabdian yang terintegrasi dengan Project Based Learning mahasiswa.', 'focus' => array('Mahasiswa terjun langsung', 'Solusi untuk mitra', 'Penguatan soft skill')),
  array('title' => 'Diseminasi & Dokumentasi', 'description' => 'Penyebarluasan dan pendokumentasian hasil pengabdian kepada masyarakat.', 'focus' => array('Seminar hasil abdimas', 'Dokumentasi luaran', 'Publikasi media massa')),
);
$pengabdian['documents'] = array(
  array('title' => 'Buku Panduan Penelitian dan Pengabdian 2026', 'description' => 'Acuan utama pengusulan proposal pengabdian tahun 2026.', 'href' => null),
  array('title' => 'Format Proposal Pengabdian', 'description' => 'Template penulisan proposal pengabdian sesuai ketentuan P3M.', 'href' => null),
  array('title' => 'Format Laporan Kemajuan', 'description' => 'Template pelaporan kemajuan kegiatan pengabdian.', 'href' => null),
);

// Kontak & tupoksi punya berkas data sendiri (dipakai API kontak/tupoksi).
// Di sini keduanya didaftarkan juga supaya bisa disunting dari panel admin.
$kontakPath = require __DIR__ . '/kontak.php';
$tupoksiPath = require __DIR__ . '/tupoksi.php';

// Halaman "Polibatam University Berdampak" — teks laporan dampak.
$berdampak = array(
  'heading' => 'Polibatam University Berdampak',
  'visitors' => 405,
  'intro' => array(
    'Politeknik Negeri Batam (Polibatam) berkomitmen untuk terus menghadirkan pendidikan vokasi yang memberikan manfaat nyata bagi masyarakat. Komitmen tersebut diwujudkan melalui Laporan Dampak Sosial, Ekonomi, dan Lingkungan Tahun 2025, yang mendokumentasikan kontribusi institusi dalam mendukung pembangunan berkelanjutan melalui pelaksanaan Tri Dharma Perguruan Tinggi dan tata kelola kelembagaan.',
    'Laporan ini menyajikan berbagai capaian Polibatam dalam menciptakan dampak pada tiga dimensi utama, yaitu dampak sosial, dampak ekonomi, dan dampak lingkungan. Di bidang ekonomi, kontribusi institusi diwujudkan melalui hilirisasi hasil riset, pengembangan kewirausahaan, serta kemitraan dengan dunia usaha dan dunia industri.',
    'Dokumen ini diharapkan menjadi referensi bagi sivitas akademika, pemerintah, dunia usaha dan dunia industri, mitra, serta masyarakat dalam memahami kontribusi nyata Polibatam terhadap pembangunan berkelanjutan.',
  ),
  'sections' => array(
    array(
      'title' => 'Unduh Laporan Dampak Sosial, Ekonomi, dan Lingkungan Politeknik Negeri Batam Tahun 2025 (PDF):',
      'paragraphs' => array(),
      'list' => array(),
      'hrefs' => array(
        array(
          'label' => 'Klik Disini',
          'url' => 'https://polbat-my.sharepoint.com/:b:/g/personal/p3m_polibatam_ac_id/IQDeI_xg-60RTr-O1opMKgpVAfMa5u5bFb4pnu1imIJG_T8?e=ZJtv19',
        ),
      ),
    ),
  ),
);

// Halaman induk HKI — pengantar yang tampil di atas daftar tahun.
$hki = array(
  'heading' => 'HKI',
  'visitors' => 8490,
  'intro' => array(
    'Hak Kekayaan Intelektual (HKI) merupakan bagian dari komitmen Polibatam University Berdampak dalam mendorong lahirnya karya intelektual yang terlindungi dan bermanfaat bagi masyarakat serta industri.',
    'Pusat Penelitian dan Pengabdian kepada Masyarakat Politeknik Negeri Batam aktif mendorong pengembangan inovasi, karya ilmiah, dan produk teknologi yang memiliki nilai komersial serta manfaat bagi masyarakat.',
  ),
  'sections' => array(
    array(
      'title' => 'Prioritas Pengembangan HKI',
      'paragraphs' => array(
        'Beberapa fokus utama pengembangan HKI meliputi teknologi tepat guna, perangkat lunak, desain produk, inovasi pendidikan, serta solusi berbasis kebutuhan industri dan masyarakat.',
      ),
      'list' => array(
        'Perlindungan inovasi produk dan teknologi',
        'Pengembangan karya riset yang aplikatif',
        'Dukungan komersialisasi hasil penelitian',
        'Kolaborasi dengan industri dan mitra strategis',
      ),
      'hrefs' => array(),
    ),
  ),
);

$kontak = array(
  'heading' => $kontakPath['heading'] ?? 'KONTAK P3M',
  'visitors' => $kontakPath['visitors'] ?? 0,
  'intro' => array(),
  'sections' => array(),
  'contact' => $kontakPath,
);

$tupoksi = array(
  'heading' => $tupoksiPath['heading'] ?? 'Tupoksi',
  'visitors' => $tupoksiPath['visitors'] ?? 0,
  'intro' => $tupoksiPath['intro'] ?? array(),
  'sections' => array(
    array(
      'title' => $tupoksiPath['duties']['title'] ?? 'Tugas dan Tanggung Jawab',
      'paragraphs' => array(),
      'list' => $tupoksiPath['duties']['items'] ?? array(),
      'hrefs' => array(),
    ),
    array(
      'title' => $tupoksiPath['authorities']['title'] ?? 'Kewenangan',
      'paragraphs' => array(),
      'list' => $tupoksiPath['authorities']['items'] ?? array(),
      'hrefs' => array(),
    ),
  ),
);

// Data kontak & tupoksi tetap berada di berkasnya sendiri (kontak.php,
// tupoksi.php) karena sudah dipakai API-nya masing-masing.
return array(
  'profil' => $profil,
  'informasi' => $informasi,
  'renstra-penelitian' => $renstra,
  'rip-pengabdian' => $rip,
  'statistik' => $statistik,
  'penelitian' => $penelitian,
  'pengabdian' => $pengabdian,
  'kontak' => $kontak,
  'tupoksi' => $tupoksi,
  'berdampak' => $berdampak,
  'hki' => $hki,
);
