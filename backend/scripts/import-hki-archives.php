<?php

/**
 * Convert downloaded original P2M HKI archive pages into the PHP data format.
 *
 * Usage: php import-hki-archives.php <source-directory> [output-file]
 * Without output-file, it prints a complete PHP return array to stdout.
 */

$sourceDir = $argv[1] ?? null;
$outputFile = $argv[2] ?? null;
$years = [2025, 2024, 2023, 2022, 2021, 2020, 2019, 2018];

if (!$sourceDir || !is_dir($sourceDir)) {
    fwrite(STDERR, "Folder sumber HTML tidak ditemukan.\n");
    exit(1);
}

function normalizeCell(DOMElement $cell): string
{
    $html = $cell->ownerDocument->saveHTML($cell);
    $html = preg_replace('/<br\s*\/?>/i', "\n", $html);
    $html = preg_replace('/<\/(?:p|li|div)>/i', "\n", $html);
    $text = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $text = str_replace(["\xc2\xa0", "\xe2\x80\x8b"], ' ', $text);
    $lines = preg_split('/\R/u', $text);
    $lines = array_map(static fn ($line) => preg_replace('/\s+/u', ' ', trim($line)), $lines);
    $lines = array_values(array_filter($lines, static fn ($line) => $line !== ''));

    return implode("\n", $lines);
}

function normalizedPlainText(string $html): string
{
    $text = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $text = str_replace("\xc2\xa0", ' ', $text);

    return preg_replace('/\s+/u', ' ', $text);
}

$archives = [];

foreach ($years as $year) {
    $path = rtrim($sourceDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . "hki-{$year}-source.html";

    if (!is_file($path)) {
        fwrite(STDERR, "Sumber tahun {$year} tidak ditemukan: {$path}\n");
        exit(1);
    }

    $html = file_get_contents($path);
    $document = new DOMDocument();
    $previous = libxml_use_internal_errors(true);
    $document->loadHTML('<?xml encoding="UTF-8">' . $html);
    libxml_clear_errors();
    libxml_use_internal_errors($previous);

    $xpath = new DOMXPath($document);
    $tableRows = null;
    $columns = [];

    foreach ($xpath->query('//table') as $table) {
        foreach ($xpath->query('.//tr', $table) as $row) {
            $cells = [];

            foreach ($xpath->query('./th|./td', $row) as $cell) {
                $cells[] = normalizeCell($cell);
            }

            if (count($cells) >= 4 && strcasecmp($cells[0], 'No') === 0) {
                $columns = array_slice($cells, 1);
                $tableRows = $xpath->query('.//tr', $table);
                break 2;
            }
        }
    }

    if (!$tableRows) {
        fwrite(STDERR, "Tabel HKI tahun {$year} tidak ditemukan.\n");
        exit(1);
    }

    $daftar = [];

    foreach ($tableRows as $row) {
        $cells = [];

        foreach ($xpath->query('./th|./td', $row) as $cell) {
            $cells[] = normalizeCell($cell);
        }

        if (count($cells) < 4 || !preg_match('/^\d+$/', $cells[0])) {
            continue;
        }

        $daftar[] = [
            'judul' => $cells[1],
            'jenis' => $cells[2],
            'pencipta' => $cells[3],
            'nomor' => $cells[4] ?? '',
        ];
    }

    $views = 0;
    if (preg_match('/class="post-views-count"[^>]*>\s*([\d,]+)/i', $html, $viewMatch)) {
        $views = (int) str_replace(',', '', $viewMatch[1]);
    }

    $plainText = normalizedPlainText($html);
    $ringkasan = ['total' => count($daftar), 'rincian' => []];
    $showSummary = false;

    if (preg_match('/terdapat\s+(\d+)\s*Judul.*?terdiri dari:\s*(.*?)(?=No\s*(?:Judul|Invensi)|$)/iu', $plainText, $summaryMatch)) {
        $showSummary = true;
        $ringkasan['total'] = (int) $summaryMatch[1];
        preg_match_all('/(\d+)\s*Judul\s*(.*?)(?=\d+\s*Judul|$)/iu', $summaryMatch[2], $details, PREG_SET_ORDER);

        foreach ($details as $detail) {
            $ringkasan['rincian'][] = [
                'jumlah' => (int) $detail[1],
                'jenis' => trim($detail[2]),
            ];
        }
    }

    $archives[(string) $year] = [
        'views' => $views,
        'show_summary' => $showSummary,
        'ringkasan' => $ringkasan,
        'kolom' => $columns,
        'daftar' => $daftar,
    ];

    fwrite(STDERR, sprintf("Tahun %d: %d entri, %d views, %d kolom\n", $year, count($daftar), $views, count($columns)));
}

$archives['2017'] = [
    'views' => 6373,
    'show_summary' => false,
    'ringkasan' => [
        'total' => 7,
        'rincian' => [],
    ],
    // CATATAN: label kolom di sini hanya untuk arsip lama (hasil impor).
    // Konvensi yang dipakai sekarang: 'Judul', 'Jenis HKI', 'Nama Pencipta', 'Nomor Permohonan'.
    'kolom' => ['Judul', 'Jenis Paten', 'Nama Inventor / Pencipta'],
    'daftar' => [
        ['judul' => 'PENAMPUNG TUTUP BOTOL PADA PEMBUKA TUTUP BOTOL', 'jenis' => 'Paten Sederhana', 'pencipta' => "Cahyo Budi Nugroho\nBudi Baharudin\nDessia Rahayu\nBella Rukmana", 'nomor' => ''],
        ['judul' => 'PLAT KLEM SEBAGAI AKSESORIS MESIN MILLING', 'jenis' => 'Paten Sederhana', 'pencipta' => "Muhammad Dzuhri M.\nCahyo Budi Nugroho\nHaris Rimbanu", 'nomor' => ''],
        ['judul' => 'MESIN PERAJANG SINGKONG DENGAN SISTEM PEDAL KAKI', 'jenis' => 'Paten Sederhana', 'pencipta' => "Cahyo Budi Nugroho\nBella Rukmana", 'nomor' => ''],
        ['judul' => 'HINT BOOK', 'jenis' => 'Hak cipta – program komputer', 'pencipta' => 'Nur Zahrati Janah', 'nomor' => ''],
        ['judul' => 'PENUMPASAN ZOMBIE', 'jenis' => 'Hak cipta – program komputer', 'pencipta' => 'Riwinoto', 'nomor' => ''],
        ['judul' => 'FAST PULSA', 'jenis' => 'Hak cipta – program komputer', 'pencipta' => 'Nur Zahrati Janah', 'nomor' => ''],
        ['judul' => 'JEJAK DI SETOKOK', 'jenis' => 'Hak cipta – sinematografi', 'pencipta' => 'Ardiman Firmanda', 'nomor' => ''],
    ],
];

$output = "<?php\n\nreturn " . var_export($archives, true) . ";\n";

if ($outputFile) {
    if (file_put_contents($outputFile, $output) === false) {
        fwrite(STDERR, "Tidak bisa menulis berkas keluaran: {$outputFile}\n");
        exit(1);
    }
} else {
    echo $output;
}
