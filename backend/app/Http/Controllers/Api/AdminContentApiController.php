<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Support\HkiRepository;
use App\Support\SiteContentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Pengelolaan konten selain berita, untuk panel admin Next.js.
 *
 *   HKI        : /api/admin/hki            (daftar tahun, simpan, hapus)
 *   Publikasi  : /api/admin/publikasi      (per tahun)
 *   Profil     : /api/admin/profil         (konten halaman statis)
 *
 * Semua endpoint menuntut token login yang sah.
 */
class AdminContentApiController extends Controller
{
    public function __construct(
        protected HkiRepository $hki,
        protected SiteContentRepository $content,
    ) {}

    // ------------------------------------------------------------------
    // HKI
    // ------------------------------------------------------------------

    /** GET /api/admin/hki */
    public function hkiIndex(Request $request): JsonResponse
    {
        if ($this->admin($request) === null) return $this->unauthorized();

        $years = $this->hki->all();
        krsort($years);

        $data = [];

        foreach ($years as $year => $group) {
            $daftar = $group['daftar'] ?? [];
            $rincian = $group['ringkasan']['rincian'] ?? [];

            $data[] = [
                'year' => (int) $year,
                'views' => (int) ($group['views'] ?? 0),
                'show_summary' => (bool) ($group['show_summary'] ?? true),
                'total' => count($daftar),
                'jenis' => array_values(array_unique(array_map(
                    fn(array $row) => (string) ($row['jenis'] ?? ''),
                    $daftar
                ))),
                'ringkasan' => $rincian,
            ];
        }

        return response()->json([
            'data' => $data,
            'meta' => ['total_tahun' => count($data)],
        ]);
    }

    /** GET /api/admin/hki/{year} -> satu tahun lengkap (untuk form ubah) */
    public function hkiShow(Request $request, int $year): JsonResponse
    {
        if ($this->admin($request) === null) return $this->unauthorized();

        $group = $this->hki->find($year);

        if ($group === null) {
            return response()->json(['message' => 'Data HKI tahun ' . $year . ' tidak ditemukan.'], 404);
        }

        return response()->json([
            'data' => [
                'year' => $year,
                'views' => (int) ($group['views'] ?? 0),
                'show_summary' => (bool) ($group['show_summary'] ?? true),
                'daftar' => $group['daftar'] ?? [],
            ],
        ]);
    }

    /** POST /api/admin/hki/{year} -> simpan satu tahun */
    public function hkiSave(Request $request, int $year): JsonResponse
    {
        if ($this->admin($request) === null) return $this->unauthorized();

        $payload = $request->validate([
            'views' => ['nullable', 'integer', 'min:0'],
            'show_summary' => ['nullable', 'boolean'],
            'daftar' => ['nullable', 'array'],
            'daftar.*.judul' => ['required_with:daftar', 'string', 'max:500'],
            'daftar.*.jenis' => ['nullable', 'string', 'max:150'],
            'daftar.*.pencipta' => ['nullable', 'string', 'max:300'],
            'daftar.*.nomor' => ['nullable', 'string', 'max:150'],
        ]);

        $daftar = array_values(array_map(fn(array $row) => [
            'judul' => trim((string) ($row['judul'] ?? '')),
            'jenis' => trim((string) ($row['jenis'] ?? '')),
            'pencipta' => trim((string) ($row['pencipta'] ?? '')),
            'nomor' => trim((string) ($row['nomor'] ?? '')),
        ], $payload['daftar'] ?? []));

        // Ringkasan dihitung ulang dari isi tabel supaya angka tidak pernah
        // berbeda dengan jumlah baris yang benar-benar tampil.
        $perJenis = [];

        foreach ($daftar as $row) {
            $jenis = $row['jenis'] !== '' ? $row['jenis'] : 'Hak Cipta';
            $perJenis[$jenis] = ($perJenis[$jenis] ?? 0) + 1;
        }

        $ringkasan = [];

        foreach ($perJenis as $jenis => $jumlah) {
            $ringkasan[] = ['jumlah' => $jumlah, 'jenis' => $jenis];
        }

        $this->hki->saveYear($year, [
            'views' => (int) ($payload['views'] ?? 0),
            'show_summary' => (bool) ($payload['show_summary'] ?? true),
            'kolom' => ['Judul', 'Jenis HKI', 'Nama Pencipta', 'Nomor Permohonan'],
            'ringkasan' => ['total' => count($daftar), 'rincian' => $ringkasan],
            'daftar' => $daftar,
        ]);

        return response()->json([
            'message' => 'Data HKI tahun ' . $year . ' disimpan.',
            'data' => ['year' => $year, 'views' => (int) ($payload['views'] ?? 0), 'total' => count($daftar)],
        ]);
    }

    /** DELETE /api/admin/hki/{year} */
    public function hkiDestroy(Request $request, int $year): JsonResponse
    {
        if ($this->admin($request) === null) return $this->unauthorized();

        if (! $this->hki->deleteYear($year)) {
            return response()->json(['message' => 'Data HKI tahun ' . $year . ' tidak ditemukan.'], 404);
        }

        return response()->json(['message' => 'Data HKI tahun ' . $year . ' dihapus.']);
    }

    // ------------------------------------------------------------------
    // Publikasi
    // ------------------------------------------------------------------

    /** GET /api/admin/publikasi */
    public function publikasiIndex(Request $request): JsonResponse
    {
        if ($this->admin($request) === null) return $this->unauthorized();

        $years = $this->content->get('publikasi', []);
        krsort($years);

        $data = [];

        foreach ($years as $year => $group) {
            $html = (string) ($group['content'] ?? '');

            $data[] = [
                'year' => (int) $year,
                'label' => $group['label'] ?? 'TAHUN ' . $year,
                'visitors' => (int) ($group['visitors'] ?? 0),
                'items' => substr_count($html, '<li'),
                'updated_at' => $group['updated_at'] ?? null,
            ];
        }

        return response()->json([
            'data' => $data,
            'meta' => ['total_tahun' => count($data)],
        ]);
    }

    /** GET /api/admin/publikasi/{year} */
    public function publikasiShow(Request $request, int $year): JsonResponse
    {
        if ($this->admin($request) === null) return $this->unauthorized();

        $years = $this->content->get('publikasi', []);

        if (! isset($years[$year])) {
            return response()->json(['message' => 'Data publikasi tahun ' . $year . ' tidak ditemukan.'], 404);
        }

        return response()->json([
            'data' => [
                'year' => $year,
                'label' => $years[$year]['label'] ?? 'TAHUN ' . $year,
                'visitors' => (int) ($years[$year]['visitors'] ?? 0),
                'content' => $years[$year]['content'] ?? '',
            ],
        ]);
    }

    /** POST /api/admin/publikasi/{year} */
    public function publikasiSave(Request $request, int $year): JsonResponse
    {
        if ($this->admin($request) === null) return $this->unauthorized();

        $payload = $request->validate([
            'visitors' => ['nullable', 'integer', 'min:0'],
            'content' => ['nullable', 'string'],
            'label' => ['nullable', 'string', 'max:80'],
        ]);

        $years = $this->content->get('publikasi', []);

        $years[$year] = [
            'label' => $payload['label'] ?? ($years[$year]['label'] ?? 'TAHUN ' . $year),
            'visitors' => (int) ($payload['visitors'] ?? $years[$year]['visitors'] ?? 0),
            'content' => $payload['content'] ?? ($years[$year]['content'] ?? ''),
            'source_page_id' => $years[$year]['source_page_id'] ?? null,
            'updated_at' => now()->toIso8601String(),
        ];

        krsort($years);
        $this->content->put('publikasi', $years);

        return response()->json([
            'message' => 'Data publikasi tahun ' . $year . ' disimpan.',
            'data' => ['year' => $year, 'items' => substr_count($years[$year]['content'], '<li')],
        ]);
    }

    // ------------------------------------------------------------------
    // Profil / halaman statis
    // ------------------------------------------------------------------

    /**
     * GET /api/admin/profil
     *
     * Halaman statis (profil, renstra, RIP, tupoksi, kontak) berasal dari
     * berkas resources/data, sedangkan teks yang disunting admin disimpan di
     * site_contents dengan kunci "halaman:<slug>". Yang dikirim di sini adalah
     * gabungannya, sehingga form admin selalu melihat isi yang sebenarnya tampil.
     */
    public function profilIndex(Request $request): JsonResponse
    {
        if ($this->admin($request) === null) return $this->unauthorized();

        $pages = $this->halamanData();
        $data = [];

        foreach ($pages as $slug => $page) {
            $override = $this->content->get('halaman:' . $slug, null);
            $merged = is_array($override) ? array_merge($page, $override) : $page;

            $data[] = [
                'slug' => $slug,
                'heading' => $merged['heading'] ?? $slug,
                'visitors' => (int) ($merged['visitors'] ?? 0),
                'intro' => $merged['intro'] ?? [],
                'edited' => is_array($override),
            ];
        }

        return response()->json(['data' => $data]);
    }

    /** GET /api/admin/profil/{slug} */
    public function profilShow(Request $request, string $slug): JsonResponse
    {
        if ($this->admin($request) === null) return $this->unauthorized();

        $pages = $this->halamanData();

        if (! isset($pages[$slug])) {
            return response()->json(['message' => 'Halaman ' . $slug . ' tidak ditemukan.'], 404);
        }

        $override = $this->content->get('halaman:' . $slug, null);
        $merged = is_array($override) ? array_merge($pages[$slug], $override) : $pages[$slug];

        return response()->json([
            'data' => array_merge(['slug' => $slug], $merged),
        ]);
    }

    /** POST /api/admin/profil/{slug} */
    public function profilSave(Request $request, string $slug): JsonResponse
    {
        if ($this->admin($request) === null) return $this->unauthorized();

        $pages = $this->halamanData();

        if (! isset($pages[$slug])) {
            return response()->json(['message' => 'Halaman ' . $slug . ' tidak ditemukan.'], 404);
        }

        $payload = $request->validate([
            'heading' => ['nullable', 'string', 'max:150'],
            'visitors' => ['nullable', 'integer', 'min:0'],
            'intro' => ['nullable', 'array'],
            'intro.*' => ['string'],
        ]);

        $this->content->put('halaman:' . $slug, [
            'heading' => $payload['heading'] ?? $pages[$slug]['heading'] ?? $slug,
            'visitors' => (int) ($payload['visitors'] ?? $pages[$slug]['visitors'] ?? 0),
            'intro' => array_values($payload['intro'] ?? ($pages[$slug]['intro'] ?? [])),
        ]);

        return response()->json(['message' => 'Halaman ' . $slug . ' disimpan.']);
    }

    // ------------------------------------------------------------------

    protected function halamanData(): array
    {
        $path = resource_path('data/halaman.php');

        if (! is_file($path)) {
            return [];
        }

        $data = require $path;

        return is_array($data) ? $data : [];
    }

    protected function admin(Request $request): ?array
    {
        return AuthApiController::adminFromToken($request->header('Authorization'));
    }

    protected function unauthorized(): JsonResponse
    {
        return response()->json(['message' => 'Tidak memiliki akses.'], 401);
    }
}
