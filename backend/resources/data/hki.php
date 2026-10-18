<?php

/**
 * Data arsip HKI per tahun — dibaca oleh:
 *   - App\Http\Controllers\Api\HkiApiController     (API untuk front end Next.js)
 *   - App\Http\Controllers\PublicPageController     (halaman dashboard Blade)
 *
 * Isi prototipe: setiap tahun berisi SATU karya berupa buku/karya tulis atas
 * nama "Amedeo Duscha Robert" dengan judul buku yang berbeda tiap tahun.
 * Semua baris ditandai CONTOH supaya tidak disalahartikan sebagai catatan HKI
 * resmi Polibatam.
 */

$pencipta = 'Amedeo Duscha Robert';
$jenisKarya = 'Hak Cipta – Karya Tulis/ Buku';

/** Kolom tabel — semua tahun memakai susunan kolom yang sama. */
$kolom = array('Judul', 'Jenis HKI', 'Nama Pencipta', 'Nomor Permohonan');

/** Judul buku CONTOH per tahun. */
$bukuPerTahun = array(
  2025 => 'CONTOH — Buku Ajar Rekayasa Perangkat Lunak Terapan',
  2024 => 'CONTOH — Buku Panduan Sistem Tertanam dan Internet of Things',
  2023 => 'CONTOH — Buku Ajar Kecerdasan Artifisial untuk Politeknik',
  2022 => 'CONTOH — Buku Praktikum Jaringan Komputer dan Keamanan Siber',
  2021 => 'CONTOH — Buku Ajar Basis Data dan Analitik untuk Industri',
  2020 => 'CONTOH — Buku Panduan Otomasi Industri dan Robotika Terapan',
  2019 => 'CONTOH — Buku Ajar Pemrograman Bergerak untuk Aplikasi Industri',
  2018 => 'CONTOH — Buku Panduan Energi Terbarukan untuk Kawasan Pesisir',
  2017 => 'CONTOH — Buku Ajar Metodologi Penelitian Terapan Teknologi',
);

/** Jumlah pengunjung per tahun (angka tampilan saja). */
$viewsPerTahun = array(
  2025 => 1770,
  2024 => 5005,
  2023 => 5500,
  2022 => 10585,
  2021 => 6416,
  2020 => 5575,
  2019 => 6280,
  2018 => 4606,
  2017 => 6373,
);

$hkiData = array();

foreach ($bukuPerTahun as $tahun => $judul) {
  $hkiData[$tahun] = array(
    'views' => $viewsPerTahun[$tahun],
    'show_summary' => true,
    'ringkasan' => array(
      'total' => 1,
      'rincian' => array(
        array('jumlah' => 1, 'jenis' => $jenisKarya),
      ),
    ),
    'kolom' => $kolom,
    'daftar' => array(
      array(
        'judul' => $judul,
        'jenis' => $jenisKarya,
        'pencipta' => $pencipta,
        'nomor' => 'CONTOH — belum terdaftar',
      ),
    ),
  );
}

return $hkiData;
