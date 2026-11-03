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
        $html = preg_replace('#<(div|span|section|article|figure|strong|b|em|i|u|small)[^>]*>#i', '', $html) ?? $html;
        $html = preg_replace('#</(div|span|section|article|figure|strong|b|em|i|u|small)>#i', '', $html) ?? $html;

        // Normalkan baris baru antar elemen blok.
        $html = preg_replace('#<(/?)(p|h[1-6]|ul|ol|li|table|tr|td|th|br)\b#i', "\n<$1$2", $html) ?? $html;

        $blocks = [];
        $counter = 0;

        $push = function (array $blok) use (&$blocks, &$counter) {
            $blok['id'] = 'b' . (++$counter);
            $blocks[] = $blok;
        };

        // Daftar butir dikumpulkan per <ul>/<ol>.
        if (preg_match_all('#<(ul|ol)[^>]*>(.*?)</\1>#is', $html, $lists, PREG_SET_ORDER)) {
            foreach ($lists as $list) {
                $items = [];

                if (preg_match_all('#<li[^>]*>(.*?)</li>#is', $list[2], $lis, PREG_SET_ORDER)) {
                    foreach ($lis as $li) {
                        $text = self::plain($li[1]);

                        if ($text !== '') {
                            $items[] = $text;
                        }
                    }
                }

                if ($items !== []) {
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

        return $blocks;
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
