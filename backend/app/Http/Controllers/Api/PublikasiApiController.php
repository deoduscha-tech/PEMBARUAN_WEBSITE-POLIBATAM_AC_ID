<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Support\SiteContentRepository;
use Illuminate\Http\JsonResponse;

/**
 * API publikasi ilmiah — dipakai halaman /publikasi di front end Next.js.
 *
 *   GET /api/publikasi         -> semua tahun + tahun yang sedang dipilih
 *   GET /api/publikasi/{tahun} -> satu tahun saja
 *
 * Data dibaca dari tabel site_contents.
 */
class PublikasiApiController extends Controller
{
    public function __construct(private SiteContentRepository $content) {}

    /**
     * Daftar menu tahun untuk navigasi.
     */
    protected function menu(array $years): array
    {
        $menu = [];

        // Keep the navigation ordered from newest year to oldest.
        krsort($years, SORT_NUMERIC);

        foreach ($years as $year) {
            $key = (string) $year;

            $menu[] = [
                'key' => $key,
                'label' => 'TAHUN ' . $key,
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
        $years = $this->content->get('publikasi', []);
        $keys = array_map('strval', array_keys($years));
        rsort($keys, SORT_NUMERIC);

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
        $years = $this->content->get('publikasi', []);

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
            'label' => 'TAHUN ' . $year,
            'visitors' => $group['visitors'] ?? 0,
            'source_page_id' => $group['source_page_id'] ?? null,
            'content' => $group['content'] ?? '',
        ];
    }
}
