<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Support\HkiRepository;
use Illuminate\Http\JsonResponse;

/**
 * API HKI — dipakai halaman /hki dan /hki/tahun-{tahun} di front end Next.js.
 *
 *   GET /api/hki            -> daftar tahun + pendaftaran
 *   GET /api/hki/{tahun}    -> tabel HKI satu tahun
 *
 * Data dibaca dari tabel hki_years.
 */
class HkiApiController extends Controller
{
    public function __construct(private HkiRepository $hki) {}

    /**
     * GET /api/hki
     */
    public function index(): JsonResponse
    {
        $years = $this->hki->all();
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
                'views' => 8490,
                'content' => '<p>Hak Kekayaan Intelektual (HKI) merupakan bagian dari komitmen Polibatam University Berdampak dalam mendorong lahirnya karya intelektual yang terlindungi dan bermanfaat bagi masyarakat serta industri.</p><ul><li>Perlindungan inovasi produk dan teknologi</li><li>Pengembangan karya riset yang aplikatif</li><li>Dukungan komersialisasi hasil penelitian</li><li>Kolaborasi dengan industri dan mitra strategis</li></ul>',
            ],
        ]);
    }

    /**
     * GET /api/hki/{tahun}
     */
    public function show(string $tahun): JsonResponse
    {
        $group = $this->hki->find((int) $tahun);

        if ($group === null) {
            return response()->json([
                'message' => 'Data HKI tahun ' . $tahun . ' tidak ditemukan.',
            ], 404);
        }

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
