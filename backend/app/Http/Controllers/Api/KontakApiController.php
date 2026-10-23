<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Support\SiteContentRepository;

/**
 * API kontak — dipakai halaman /kontak di front end Next.js.
 *
 *   GET /api/kontak -> alamat, telepon, email, jam layanan, peta
 */
class KontakApiController extends Controller
{
    public function __construct(private SiteContentRepository $content) {}
    /**
     * GET /api/kontak
     */
    public function index(): JsonResponse
    {
        return response()->json(['data' => $this->content->get('kontak')]);
    }
}
