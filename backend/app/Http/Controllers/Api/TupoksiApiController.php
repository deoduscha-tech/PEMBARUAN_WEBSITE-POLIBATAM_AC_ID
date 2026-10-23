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
     */
    public function index(): JsonResponse
    {
        return response()->json(['data' => $this->content->get('tupoksi')]);
    }
}
