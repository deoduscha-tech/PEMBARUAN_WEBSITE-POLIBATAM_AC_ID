<?php

namespace App\Support;

/**
 * Pengubah HTML lama menjadi blok terstruktur.
 *
 * Beberapa data (misalnya konten publikasi hasil impor situs lama) tersimpan
 * sebagai HTML mentah. Supaya admin tidak perlu menyunting HTML, isi tersebut
 * dipecah otomatis menjadi blok: sub judul, paragraf, daftar butir, dan tautan.
 *
 * Hasilnya array blok dengan bentuk yang sama seperti editor di front end.
 */
class HtmlToBlocks
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public static function convert(string $html): array
    {
        $html = trim($html);

        if ($html === '') {
            return [];
        }

        // Bersihkan tag pembungkus yang tidak membawa arti.
        $html = preg_replace('#<(script|style|iframe)[^>]*>.*?</\1>#is', '', $html) ?? $html;

        // Saat halaman situs lama diambil utuh, menu sidebar ikut tersedot
        // ("LUARAN PUBLIKASI" + daftar A/B/C/D tanpa isi). Buang bagian itu
        // supaya tidak muncul sebagai sisa menu di bawah konten.
        $html = preg_replace('#LUARAN\s+PUBLIKASI#i', '', $html) ?? $html;

        // Daftar isi / sidebar situs lama yang ikut tersedot (mis. deretan
        // "A. Penelitian Terapan", "B. …", "Pengabdian Kerjasama").
        // Dibiarkan di sini; pembersihannya dilakukan setelah blok jadi, karena
        // di HTML mentah batasnya sulit dikenali dengan andal.

        // Buang blok menu navigasi situs lama (menu tahun, SINTA, JURNAL,
        // STATISTIK, dsb.). Polanya: <ul> berisi <li> pendek yang seluruhnya
        // berupa tautan menu, tanpa kalimat panjang.
        $html = preg_replace_callback(
            '#<(ul|ol)[^>]*>(.*?)</\1>#is',
            static function (array $m): string {
                if (preg_match_all('#<li[^>]*>(.*?)</li>#is', $m[2], $lis, PREG_SET_ORDER) === 0) {
                    return $m[0];
                }

                $pendek = 0;

                foreach ($lis as $li) {
                    $teks = trim(html_entity_decode(strip_tags($li[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                    $teks = preg_replace('/\s+/u', ' ', $teks) ?? $teks;

                    if (mb_strlen($teks) <= 60) {
                        $pendek++;
                    }
                }

                // Semua butir pendek => ini menu, bukan isi publikasi.
                return $pendek === count($lis) ? '' : $m[0];
            },
            $html
        ) ?? $html;

        // <br> jadi pemisah baris.
        $html = preg_replace('#<br\s*/?>#i', "\n", $html) ?? $html;

        // Penanda entri lama: pada sebagian data (mis. publikasi 2015) setiap
        // entri dipisah <strong>…</strong> tanpa <p>/<li>. Sebelum tag lain
        // dihapus, penutup </strong> diubah menjadi pemisah baris supaya tiap
        // entri tetap terpisah.
        $html = preg_replace('#</(strong|b)>#i', "\n", $html) ?? $html;

        // Baru setelah itu tag pemisah lain dibuang (daftar <li>/<ul> sudah
        // ditangani terpisah di bawah, jadi tidak ikut dihapus).
        $html = preg_replace('#</?(div|span|section|article|figure|font|p|strong|b|em|i|u|small|h[1-6])\b[^>]*>#i', "\n", $html) ?? $html;

        // Normalkan baris baru antar elemen blok.
        $html = preg_replace('#<(/?)(p|h[1-6]|ul|ol|li|table|tr|td|th)\b#i', "\n<$1$2", $html) ?? $html;

        $blocks = [];
        $counter = 0;

        $push = function (array $blok) use (&$blocks, &$counter) {
            $blok['id'] = 'b' . (++$counter);
            $blocks[] = $blok;
        };

        // Daftar butir dikumpulkan per <ul>/<ol>. Judul kategori (mis.
        // "A. Publikasi Jurnal Internasional") dicari di teks sebelum daftar dan
        // dipakai sebagai judul blok "seksi" supaya isi terkelompok rapi.
        if (preg_match_all('#<(ul|ol)[^>]*>(.*?)</\1>#is', $html, $lists, PREG_SET_ORDER | PREG_OFFSET_CAPTURE)) {
            $posisiTerakhir = 0;

            foreach ($lists as $list) {
                $awalDaftar = $list[0][1];
                $items = [];

                if (preg_match_all('#<li[^>]*>(.*?)</li>#is', $list[2][0], $lis, PREG_SET_ORDER)) {
                    foreach ($lis as $li) {
                        $text = self::plain($li[1]);

                        if ($text === '') {
                            continue;
                        }

                        // Tautan di dalam butir (mis. judul artikel jurnal) tetap
                        // disimpan supaya isinya bisa diklik di halaman publik.
                        $url = null;

                        if (preg_match('#<a[^>]+href="([^"]+)"#i', $li[1], $m)) {
                            $url = trim($m[1]);
                        }

                        $items[] = $url !== null && $url !== ''
                            ? ['teks' => $text, 'url' => $url]
                            : $text;
                    }
                }

                // Judul kategori = teks terakhir sebelum daftar dimulai.
                $sebelum = substr($html, $posisiTerakhir, max(0, $awalDaftar - $posisiTerakhir));
                $posisiTerakhir = $awalDaftar + strlen($list[0][0]);
                $judul = self::judulKategori($sebelum);

                if ($items !== []) {
                    if ($judul !== null) {
                        $push(['tipe' => 'seksi', 'judul' => $judul]);
                    }

                    $push(['tipe' => 'daftar', 'items' => $items]);
                }
            }

            // Buang daftar dari HTML supaya tidak diproses dua kali.
            $html = preg_replace('#<(ul|ol)[^>]*>.*?</\1>#is', '', $html) ?? $html;
        }

        // Tabel: ambil header + baris.
        if (preg_match_all('#<table[^>]*>(.*?)</table>#is', $html, $tables, PREG_SET_ORDER)) {
            foreach ($tables as $table) {
                $kolom = [];
                $baris = [];

                if (preg_match_all('#<tr[^>]*>(.*?)</tr>#is', $table[1], $rows, PREG_SET_ORDER)) {
                    foreach ($rows as $index => $row) {
                        $cells = [];

                        if (preg_match_all('#<(td|th)[^>]*>(.*?)</\1>#is', $row[1], $tds, PREG_SET_ORDER)) {
                            foreach ($tds as $td) {
                                $cells[] = self::plain($td[2]);
                            }
                        }

                        if ($cells === []) {
                            continue;
                        }

                        if ($index === 0) {
                            $kolom = $cells;
                        } else {
                            $baris[] = $cells;
                        }
                    }
                }

                if ($baris !== []) {
                    $push([
                        'tipe' => 'tabel',
                        'kolom' => $kolom !== [] ? $kolom : array_fill(0, count($baris[0]), ''),
                        'baris' => $baris,
                    ]);
                }
            }

            $html = preg_replace('#<table[^>]*>.*?</table>#is', '', $html) ?? $html;
        }

        // Sisa HTML: judul, paragraf, dan tautan lepas.
        $lines = preg_split('#\n+#', $html) ?: [];

        foreach ($lines as $line) {
            $line = trim($line);

            if ($line === '') {
                continue;
            }

            if (preg_match('#<h[1-6][^>]*>(.*?)</h[1-6]>#is', $line, $m)) {
                $text = self::plain($m[1]);

                if ($text !== '') {
                    $push(['tipe' => 'heading', 'teks' => $text]);
                }

                continue;
            }

            $text = self::plain($line);

            if ($text === '') {
                // Baris yang isinya hanya tautan -> blok tautan.
                if (preg_match_all('#<a[^>]+href="([^"]+)"[^>]*>(.*?)</a>#is', $line, $links, PREG_SET_ORDER)) {
                    $items = [];

                    foreach ($links as $link) {
                        $items[] = ['label' => self::plain($link[2]) ?: $link[1], 'url' => $link[1]];
                    }

                    if ($items !== []) {
                        $push(['tipe' => 'tautan', 'items' => $items]);
                    }
                }

                continue;
            }

            // Paragraf yang memuat tautan panjang (mis. daftar publikasi) -> tautan.
            if (preg_match_all('#<a[^>]+href="([^"]+)"[^>]*>(.*?)</a>#is', $line, $links, PREG_SET_ORDER) && count($links) > 1) {
                $items = [];

                foreach ($links as $link) {
                    $items[] = ['label' => self::plain($link[2]) ?: $link[1], 'url' => $link[1]];
                }

                $push(['tipe' => 'tautan', 'items' => $items]);
                continue;
            }

            $push(['tipe' => 'paragraf', 'teks' => $text]);
        }

        return self::bersihkanSisaMenu($blocks);
    }

    /**
     * Buang sisa daftar-isi/menu situs lama dari hasil konversi.
     *
     * Cirinya: blok paragraf pendek (judul kategori, tanpa angka dan tanpa
     * tanda titik-panjang) yang berurutan SETELAH blok daftar terakhir.
     * Isi publikasi selalu panjang dan memakai "–"; menu tidak.
     *
     * @param  array<int, array<string, mixed>>  $blocks
     * @return array<int, array<string, mixed>>
     */
    public static function bersihkanSisaMenu(array $blocks): array
    {
        $akhirDaftar = -1;

        foreach ($blocks as $i => $blok) {
            if (in_array($blok['tipe'] ?? '', ['daftar', 'tabel', 'gambar'], true)) {
                $akhirDaftar = $i;
            }
        }

        if ($akhirDaftar === -1) {
            return $blocks;
        }

        $bersih = [];

        foreach ($blocks as $i => $blok) {
            if ($i > $akhirDaftar && ($blok['tipe'] ?? '') === 'paragraf') {
                $teks = trim((string) ($blok['teks'] ?? ''));

                // Paragraf pendek tanpa kalimat penjelas = sisa menu.
                if ($teks === '' || (mb_strlen($teks) <= 70 && ! preg_match('#\s[–-]\s#u', $teks))) {
                    continue;
                }
            }

            if ($i > $akhirDaftar && ($blok['tipe'] ?? '') === 'seksi') {
                // Judul kategori tanpa butir setelahnya juga sisa menu.
                continue;
            }

            $bersih[] = $blok;
        }

        return array_values($bersih);
    }

    /**
     * Ambil judul kategori dari HTML sebelum daftar.
     *
     * Formatnya berbeda tiap tahun:
     *   2026 -> "A. Publikasi Jurnal Internasional Berputasi"
     *   2022 -> "Jurnal Nasional", "Publikasi Luaran", "Pengabdian Desa Wisata"
     *   2015 -> "Publikasi Melalui Jurnal", "Publikasi Penelitian Melalui Seminar"
     *
     * Aturannya: ambil baris terakhir sebelum daftar, tapi buang baris yang
     * merupakan sisa isi butir daftar sebelumnya (mengandung "–" atau sangat
     * panjang).
     */
    public static function judulKategori(string $html): ?string
    {
        // Buang tag, ambil baris-baris teks.
        $teks = preg_replace('#<[^>]+>#', "\n", $html) ?? $html;
        $teks = html_entity_decode($teks, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $baris = array_filter(
            array_map('trim', preg_split('#\n+#', $teks) ?: []),
            fn ($b) => $b !== ''
        );

        foreach (array_reverse($baris) as $kandidat) {
            $kandidat = preg_replace('/\s+/u', ' ', $kandidat) ?? $kandidat;
            $panjang = mb_strlen($kandidat);

            // Kategori selalu pendek.
            if ($panjang < 4 || $panjang > 90) {
                continue;
            }

            // Lewati sisa butir daftar sebelumnya: "Nama – Judul …".
            if (mb_strpos($kandidat, ' – ') !== false || mb_strpos($kandidat, ' - ') !== false) {
                continue;
            }

            // Lewati kalimat/isorat panjang yang berakhir titik.
            if (preg_match('#[.;:]$#u', $kandidat) && $panjang > 60) {
                continue;
            }

            // Harus berupa frasa judul (kapital di awal).
            if (! preg_match('/^[A-Z]/u', $kandidat)) {
                continue;
            }

            return $kandidat;
        }

        return null;
    }

    /** HTML -> teks polos satu baris. */
    public static function plain(string $html): string
    {
        $text = preg_replace('#<a[^>]*>(.*?)</a>#is', '$1', $html) ?? $html;
        $text = strip_tags($text);
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/\s+/u', ' ', $text) ?? $text;

        return trim($text);
    }
}
