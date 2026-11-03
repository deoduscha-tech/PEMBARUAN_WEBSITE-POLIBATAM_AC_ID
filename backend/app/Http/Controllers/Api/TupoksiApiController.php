<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Support\SiteContentRepository;

/**
 * API Tupoksi — dipakai halaman /tupoksi di front end Next.js.
 *
 *   GET /api/tupoksi -> pengantar, tugas & tanggung jawab, kewenangan
 */
class TupoksiApiController extends Controller
{
    public function __construct(private SiteContentRepository $content) {}
    /**
     * GET /api/tupoksi
     *
     * Suntingan admin (":tupoksi"): heading, intro, duties, authorities.
     * Kalau belum disunting, diambil dari resources/data/tupoksi.php.
     */
    public function index(): JsonResponse
    {
        $data = $this->content->get('tupoksi');

        if (is_array($data)) {
            return response()->json(['data' => $data]);
        }

        $path = resource_path('data/tupoksi.php');
        $fallback = is_file($path) ? (require $path) : null;

        return response()->json(['data' => is_array($fallback) ? $fallback : null]);
    }
}
