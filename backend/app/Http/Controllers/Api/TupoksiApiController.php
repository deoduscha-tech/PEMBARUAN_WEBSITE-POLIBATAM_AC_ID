<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * API Tupoksi — dipakai halaman /tupoksi di front end Next.js.
 *
 *   GET /api/tupoksi -> pengantar, tugas & tanggung jawab, kewenangan
 */
class TupoksiApiController extends Controller
{
    /**
     * GET /api/tupoksi
     */
    public function index(): JsonResponse
    {
        $path = resource_path('data/tupoksi.php');

        if (! is_file($path)) {
            return response()->json(['data' => null]);
        }

        $data = require $path;

        return response()->json([
            'data' => is_array($data) ? $data : null,
        ]);
    }
}
