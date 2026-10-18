<?php

/**
 * Skrip bantu (sekali pakai) untuk mengubah tabel HTML halaman
 * "HKI TAHUN 20xx" dari situs asli menjadi array PHP yang dipakai
 * resources/data/hki.php.
 *
 * Cara pakai:
 *   php backend/scripts/parse-hki.php <berkas-html> <tahun>
 *
 * Simpan HTML halaman asli ke berkas dulu (mis. simpan dari browser),
 * lalu jalankan skrip ini untuk mencetak blok array yang siap ditempel.
 */

$file = $argv[1] ?? null;
$tahun = $argv[2] ?? '2025';

if (!$file || !is_file($file)) {
    fwrite(STDERR, "Berkas HTML tidak ditemukan.\n");
    exit(1);
}

$html = file_get_contents($file);

// Ambil hanya isi <tbody> ... </tbody> dari tabel daftar HKI.
if (!preg_match('/<tbody>(.*?)<\/tbody>/s', $html, $m)) {
    fwrite(STDERR, "Tabel <tbody> tidak ditemukan pada berkas.\n");
    exit(1);
}

$body = $m[1];

preg_match_all('/<tr>(.*?)<\/tr>/s', $body, $rows);

$out = [];

foreach ($rows[1] as $row) {
    preg_match_all('/<td[^>]*>(.*?)<\/td>/s', $row, $cells);

    if (count($cells[1]) < 5) {
        continue;
    }

    // Kolom: No | Judul | Jenis HKI | Pencipta | Nomor Permohonan
    $clean = function (string $value): string {
        $value = preg_replace('/<br\s*\/?>/i', ' ', $value);
        $value = strip_tags($value);
        $value = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $value = str_replace("\xc2\xa0", ' ', $value); // nbsp
        $value = preg_replace('/\s+/', ' ', $value);

        return trim($value, " \t\n\r\0\x0B;");
    };

    $judul = $clean($cells[1][1]);
    $jenis = $clean($cells[1][2]);
    $pencipta = $clean($cells[1][3]);
    $nomor = $clean($cells[1][4]);

    if ($judul === '') {
        continue;
    }

    $out[] = sprintf(
        "            ['judul' => %s, 'jenis' => %s, 'pencipta' => %s, 'nomor' => %s],",
        var_export($judul, true),
        var_export($jenis, true),
        var_export($pencipta, true),
        var_export($nomor, true),
    );
}

echo "        'daftar' => [\n";
echo implode("\n", $out);
echo "\n        ],\n";

fwrite(STDERR, sprintf("Total baris: %d (tahun %s)\n", count($out), $tahun));
