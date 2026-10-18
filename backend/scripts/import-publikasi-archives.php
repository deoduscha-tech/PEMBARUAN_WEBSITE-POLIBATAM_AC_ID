<?php

/**
 * Import the official P2M publication archive pages as safe HTML fragments.
 *
 * Usage: php import-publikasi-archives.php <source-directory> [output-file]
 */

$sourceDir = $argv[1] ?? null;
$outputFile = $argv[2] ?? null;
$pages = [
    2026 => 8909, 2025 => 8955, 2024 => 8087, 2023 => 7752,
    2022 => 6994, 2021 => 6323, 2020 => 4738, 2019 => 4114,
    2018 => 3677, 2017 => 3092, 2016 => 2497, 2015 => 1998,
    2014 => 1339, 2013 => 1127, 2012 => 686, 2011 => 671, 2010 => 900,
];

if (!$sourceDir || !is_dir($sourceDir)) {
    fwrite(STDERR, "Folder sumber HTML tidak ditemukan.\n");
    exit(1);
}

function safeNodeHtml(DOMNode $node, DOMDocument $output): string
{
    $allowed = ['div', 'p', 'span', 'strong', 'b', 'em', 'i', 'u', 'br', 'ol', 'ul', 'li', 'a', 'h1', 'h2', 'h3', 'h4', 'h5', 'table', 'thead', 'tbody', 'tr', 'th', 'td', 'blockquote'];

    if ($node instanceof DOMText) {
        return htmlspecialchars($node->nodeValue ?? '', ENT_NOQUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    if (!$node instanceof DOMElement) {
        return '';
    }

    $tag = strtolower($node->tagName);
    $children = '';

    foreach ($node->childNodes as $child) {
        $children .= safeNodeHtml($child, $output);
    }

    if (!in_array($tag, $allowed, true)) {
        return $children;
    }

    if ($tag === 'a') {
        $href = trim($node->getAttribute('href'));
        if ($href !== '' && preg_match('/^(https?:|mailto:)/i', $href)) {
            return '<a href="' . htmlspecialchars($href, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '" target="_blank" rel="noopener noreferrer">' . $children . '</a>';
        }
    }

    if ($tag === 'br') {
        return '<br>';
    }

    return '<' . $tag . '>' . $children . '</' . $tag . '>';
}

$archives = [];

foreach ($pages as $year => $pageId) {
    $path = rtrim($sourceDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $year . '.html';

    if (!is_file($path)) {
        fwrite(STDERR, "Sumber tahun {$year} tidak ditemukan: {$path}\n");
        exit(1);
    }

    $document = new DOMDocument();
    $previous = libxml_use_internal_errors(true);
    $document->loadHTML('<?xml encoding="UTF-8">' . file_get_contents($path));
    libxml_clear_errors();
    libxml_use_internal_errors($previous);
    $xpath = new DOMXPath($document);
    $contentBox = $xpath->query('//main[@id="content"]//*[contains(concat(" ", normalize-space(@class), " "), " mg-card-box ")]')->item(0);

    if (!$contentBox) {
        fwrite(STDERR, "Konten utama tahun {$year} tidak ditemukan.\n");
        exit(1);
    }

    $exclude = $xpath->query('.//*[@id="comments" or @id="respond" or contains(concat(" ", normalize-space(@class), " "), " comments-area ") or contains(concat(" ", normalize-space(@class), " "), " comment-respond ")]', $contentBox);
    foreach ($exclude as $element) {
        $element->parentNode?->removeChild($element);
    }

    $content = '';
    foreach ($contentBox->childNodes as $child) {
        $content .= safeNodeHtml($child, $document);
    }

    $visitorNode = $xpath->query('//*[contains(concat(" ", normalize-space(@class), " "), " post-views-count ")]')->item(0);
    $visitors = $visitorNode ? (int) preg_replace('/\D+/', '', $visitorNode->textContent) : 0;
    $archives[(string) $year] = [
        'source_page_id' => $pageId,
        'visitors' => $visitors,
        'content' => trim($content),
    ];

    fwrite(STDERR, "Tahun {$year}: " . strlen($content) . " karakter, {$visitors} pengunjung.\n");
}

$php = "<?php\n\n// Konten arsip publikasi yang diambil dari halaman resmi Pusat P2M Polibatam.\nreturn " . var_export($archives, true) . ";\n";

if ($outputFile) {
    file_put_contents($outputFile, $php);
} else {
    echo $php;
}
