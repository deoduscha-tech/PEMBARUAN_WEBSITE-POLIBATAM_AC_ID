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
     *
     * Suntingan admin disimpan di site_contents ("halaman:kontak" -> contact).
     * Kalau belum pernah disunting, isi diambil dari resources/data/kontak.php.
     */
    public function index(): JsonResponse
    {
        // Isi dasar dari berkas, lalu ditimpa suntingan admin (bila ada).
        $path = resource_path('data/kontak.php');
        $base = is_file($path) ? (require $path) : [];
        $base = is_array($base) ? $base : [];

        // Kunci "kontak" (ditulis saat suntingan pertama) dan
        // "halaman:kontak" -> contact (dari form admin) sama-sama dipakai.
        $versi = $this->content->get('kontak');
        $form = $this->content->get('halaman:kontak');
        $formContact = is_array($form) ? ($form['contact'] ?? null) : null;

        foreach ([is_array($formContact) ? $formContact : null, is_array($versi) ? $versi : null] as $sumber) {
            if (! is_array($sumber)) {
                continue;
            }

            foreach ($sumber as $kunci => $nilai) {
                if (is_array($nilai) && isset($base[$kunci]) && is_array($base[$kunci])) {
                    $base[$kunci] = array_replace_recursive($base[$kunci], $nilai);
                } else {
                    $base[$kunci] = $nilai;
                }
            }
        }

        return response()->json(['data' => $base ?: null]);
    }
}
