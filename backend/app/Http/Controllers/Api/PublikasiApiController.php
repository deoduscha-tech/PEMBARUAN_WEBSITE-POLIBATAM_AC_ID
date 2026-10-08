<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * API publikasi ilmiah — dipakai halaman /publikasi di front end Next.js.
 *
 *   GET /api/publikasi         -> semua tahun + tahun yang sedang dipilih
 *   GET /api/publikasi/{tahun} -> satu tahun saja
 *
 * Data dibaca dari resources/data/publikasi.php. Kalau nanti pindah ke MySQL,
 * cukup ganti isi data() — controller dan tampilan tidak perlu diubah.
 */
class PublikasiApiController extends Controller
{
    /** Judul halaman untuk tiap tahun. */
    protected const LABELS = [
        '2026' => 'TAHUN 2026',
        '2025' => 'TAHUN 2025',
        '2024' => 'TAHUN 2024',
    ];

    protected function data(): array
    {
        $path = resource_path('data/publikasi.php');

        if (! is_file($path)) {
            return [];
        }

        $data = require $path;

        return is_array($data) ? $data : [];
    }

    /**
     * Daftar menu tahun untuk navigasi.
     */
    protected function menu(array $years): array
    {
        $menu = [];

        foreach ($years as $year) {
            $key = (string) $year;

            $menu[] = [
                'key' => $key,
                'label' => self::LABELS[$key] ?? ('TAHUN ' . $key),
                'href' => '/publikasi?tahun=' . $key,
            ];
        }

        return $menu;
    }

    /**
     * GET /api/publikasi
     */
    public function index(): JsonResponse
    {
        $years = $this->data();
        $keys = array_map('strval', array_keys($years));

        $requested = (string) request()->query('tahun', $keys[0] ?? '2026');

        if (! isset($years[$requested])) {
            $requested = $keys[0] ?? '2026';
        }

        return response()->json([
            'data' => [
                'years' => $keys,
                'menu' => $this->menu($keys),
                'active' => $this->group($requested, $years[$requested] ?? []),
            ],
        ]);
    }

    /**
     * GET /api/publikasi/{tahun}
     */
    public function show(string $tahun): JsonResponse
    {
        $years = $this->data();

        if (! isset($years[$tahun])) {
            return response()->json([
                'message' => 'Data publikasi tahun ' . $tahun . ' tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'data' => $this->group($tahun, $years[$tahun]),
        ]);
    }

    /**
     * Susun satu tahun menjadi bentuk yang dipakai tampilan.
     */
    protected function group(string $year, array $group): array
    {
        return [
            'year' => $year,
            'label' => self::LABELS[$year] ?? ('TAHUN ' . $year),
            'visitors' => $group['visitors'] ?? 0,
            'description' => $group['description'] ?? '',
            'note' => $group['note'] ?? '',
            'sections' => $group['sections'] ?? [],
        ];
    }
}
