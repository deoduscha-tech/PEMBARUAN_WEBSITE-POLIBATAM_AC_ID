<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * API kontak — dipakai halaman /kontak di front end Next.js.
 *
 *   GET /api/kontak -> alamat, telepon, email, jam layanan, peta
 */
class KontakApiController extends Controller
{
    /**
     * GET /api/kontak
     */
    public function index(): JsonResponse
    {
        $path = resource_path('data/kontak.php');

        if (! is_file($path)) {
            return response()->json(['data' => null]);
        }

        $data = require $path;

        return response()->json([
            'data' => is_array($data) ? $data : null,
        ]);
    }
}
