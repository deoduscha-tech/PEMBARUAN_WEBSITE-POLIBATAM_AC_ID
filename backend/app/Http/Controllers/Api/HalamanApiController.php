<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * API halaman statis — dipakai halaman profil, informasi, renstra, RIP,
 * statistik, penelitian, dan pengabdian di front end Next.js.
 *
 *   GET /api/halaman           -> semua halaman + daftar slug
 *   GET /api/halaman/{slug}    -> satu halaman
 *
 * Sumber data: resources/data/halaman.php (satu-satunya tempat menyimpan
 * konten), sehingga Blade dan Next.js membaca isi yang sama persis.
 */
class HalamanApiController extends Controller
{
    /**
     * Konten halaman = isi berkas resources/data/halaman.php, DITIMPA oleh
     * suntingan admin (site_contents -> "halaman:<slug>") bila ada. Dengan
     * begitu teks yang diubah di panel admin langsung tampil di website.
     */
    protected function data(): array
    {
        $path = resource_path('data/halaman.php');
        $data = is_file($path) ? (require $path) : [];
        $data = is_array($data) ? $data : [];

        $content = app(\App\Support\SiteContentRepository::class);

        foreach (array_keys($data) as $slug) {
            $override = $content->get('halaman:' . $slug, null);

            if (is_array($override)) {
                $data[$slug] = array_merge($data[$slug], $override);
            }
        }

        return $data;
    }

    /**
     * GET /api/halaman
     */
    public function index(): JsonResponse
    {
        $pages = $this->data();

        return response()->json([
            'data' => $pages,
            'meta' => [
                'slugs' => array_keys($pages),
            ],
        ]);
    }

    /**
     * GET /api/halaman/{slug}
     */
    public function show(string $slug): JsonResponse
    {
        $pages = $this->data();

        if (! isset($pages[$slug])) {
            return response()->json([
                'message' => 'Halaman ' . $slug . ' tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'data' => array_merge(['slug' => $slug], $pages[$slug]),
        ]);
    }
}
