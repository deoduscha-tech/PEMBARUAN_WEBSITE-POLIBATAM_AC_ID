<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * API HKI — dipakai halaman /hki dan /hki/tahun-{tahun} di front end Next.js.
 *
 *   GET /api/hki            -> daftar tahun + pendaftaran
 *   GET /api/hki/{tahun}    -> tabel HKI satu tahun
 *
 * Data dibaca dari resources/data/hki.php.
 */
class HkiApiController extends Controller
{
    protected function data(): array
    {
        $path = resource_path('data/hki.php');

        if (!is_file($path)) {
            return [];
        }

        $data = require $path;

        return is_array($data) ? $data : [];
    }

    /**
     * GET /api/hki
     */
    public function index(): JsonResponse
    {
        $years = $this->data();
        krsort($years);

        $menu = [];

        foreach (array_keys($years) as $year) {
            $menu[] = [
                'key' => (string) $year,
                'label' => 'HKI TAHUN ' . $year,
                'href' => '/hki/tahun-' . $year,
            ];
        }

        return response()->json([
            'data' => [
                'menu' => $menu,
            ],
        ]);
    }

    /**
     * GET /api/hki/{tahun}
     */
    public function show(string $tahun): JsonResponse
    {
        $years = $this->data();

        if (!isset($years[$tahun])) {
            return response()->json([
                'message' => 'Data HKI tahun ' . $tahun . ' tidak ditemukan.',
            ], 404);
        }

        $group = $years[$tahun];

        return response()->json([
            'data' => [
                'year' => $tahun,
                'label' => 'HKI TAHUN ' . $tahun,
                'views' => $group['views'] ?? 0,
                'show_summary' => $group['show_summary'] ?? true,
                'ringkasan' => $group['ringkasan'] ?? ['total' => 0, 'rincian' => []],
                'kolom' => $group['kolom'] ?? ['Judul', 'Jenis HKI', 'Nama Pencipta', 'Nomor Permohonan'],
                'daftar' => $group['daftar'] ?? [],
            ],
        ]);
    }
}
