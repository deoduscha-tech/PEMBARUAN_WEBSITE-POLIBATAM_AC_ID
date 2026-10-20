<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Support\NewsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * JSON API consumed by the Next.js front end.
 *
 * The Blade views are left untouched while the migration is in progress, so
 * both front ends can read the same flat-file store without conflict.
 */
class NewsApiController extends Controller
{
    public function __construct(
        protected NewsRepository $news,
    ) {}

    /**
     * GET /api/berita
     *
     * Query params: limit (int), category (string), featured (bool),
     *               q (pencarian judul/isi), page (int), per_page (int).
     *
     * Tanpa `page`/`per_page`, semua berita dikembalikan sekaligus. Kalau salah
     * satunya dikirim, hasilnya dipotong per halaman dan `meta` memuat
     * page/last_page/per_page supaya komponen Pagination front end bisa bekerja.
     */
    public function index(Request $request): JsonResponse
    {
        $posts = $this->news->published();

        if ($request->filled('category')) {
            $posts = $posts->where('category', $request->string('category')->toString());
        }

        if ($request->boolean('featured')) {
            $posts = $posts->where('featured', true);
        }

        if ($request->filled('q')) {
            $term = mb_strtolower($request->string('q')->toString());
            $posts = $posts->filter(
                fn (array $post) => str_contains(mb_strtolower($post['title']), $term)
                    || str_contains(mb_strtolower((string) ($post['excerpt'] ?? '')), $term)
                    || str_contains(mb_strtolower((string) ($post['body'] ?? '')), $term)
            )->values();
        }

        $total = $posts->count();

        $meta = [
            'total' => $total,
            'categories' => $this->news->categories()->values(),
        ];

        $limit = $request->integer('limit');
        $perPage = $request->integer('per_page');

        if ($request->filled('page') || $perPage > 0) {
            $perPage = max(1, $perPage > 0 ? $perPage : 6);
            $lastPage = max(1, (int) ceil($total / $perPage));
            $page = min(max(1, $request->integer('page', 1)), $lastPage);

            $posts = $posts->forPage($page, $perPage)->values();

            $meta += [
                'page' => $page,
                'per_page' => $perPage,
                'last_page' => $lastPage,
                'from' => $total > 0 ? ($page - 1) * $perPage + 1 : 0,
                'to' => min($page * $perPage, $total),
            ];
        }

        if ($limit > 0) {
            $posts = $posts->take($limit)->values();
        }

        return response()->json([
            'data' => $posts->values(),
            'meta' => $meta,
        ]);
    }

    /**
     * GET /api/berita/{slug}
     */
    public function show(string $slug): JsonResponse
    {
        $post = $this->news->find($slug);

        if ($post === null || ! ($post['published'] ?? true)) {
            return response()->json(['message' => 'Berita tidak ditemukan.'], 404);
        }

        return response()->json([
            'data' => $post,
            'related' => $this->news->related($post)->values(),
        ]);
    }

    /**
     * GET /api/beranda
     *
     * Everything the landing page needs in a single request.
     */
    public function home(): JsonResponse
    {
        return response()->json([
            'featured' => $this->news->featured()->take(3)->values(),
            'homePosts' => $this->news->published()->values(),
            'latestPosts' => $this->news->latest(4)->values(),
            'popularPosts' => $this->news->popular(4)->values(),
            'trendingPosts' => $this->news->popular(4)->values(),
            'missedCards' => $this->news->latest(4)->values(),
        ]);
    }

    /**
     * GET /api/laporan-tahunan
     *
     * Editorial page payload. $reportFile stays null until a PDF is uploaded,
     * which is what keeps the front end from rendering a dead link.
     */
    public function laporanTahunan(): JsonResponse
    {
        return response()->json([
            'reportYear' => '2025',
            'reportFile' => null,
            'title' => 'LAPORAN TAHUNAN P3M TAHUN 2025',
            'visitors' => 264,
            // The report narrative. Kept here so both front ends read the same
            // copy instead of duplicating the paragraphs in each one.
            'paragraphs' => [
                'Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) Politeknik Negeri Batam merupakan unit yang mengelola, memfasilitasi, dan mengembangkan kegiatan penelitian serta pengabdian kepada masyarakat sebagai implementasi Tri Dharma Perguruan Tinggi. Melalui kolaborasi dengan dosen, pusat kajian, pusat unggulan, dunia usaha, dunia industri, pemerintah, dan masyarakat, P3M berkomitmen menghasilkan riset yang inovatif, berkualitas, dan memberikan manfaat nyata bagi pembangunan nasional.',
                'Sepanjang tahun 2025, P3M berhasil menunjukkan kinerja yang sangat baik dengan penyelesaian 100% terhadap seluruh Indikator Kinerja Utama (IKU). Berbagai capaian strategis berhasil diraih, di antaranya 99 publikasi internasional, 163 pendaftaran Hak Kekayaan Intelektual (HKI), 79 luaran penelitian berbasis Project Based Learning (PBL) yang dimanfaatkan oleh industri, serta 29 kegiatan pengabdian kepada masyarakat yang melibatkan 233 dosen. Capaian tersebut mencerminkan komitmen P3M dalam memperkuat ekosistem riset, inovasi, hilirisasi teknologi, dan pengabdian yang berdampak bagi masyarakat serta mendukung peningkatan daya saing Politeknik Negeri Batam di tingkat nasional maupun internasional.',
                'P3M akan terus mendorong peningkatan kualitas penelitian, publikasi ilmiah bereputasi, perlindungan kekayaan intelektual, kemitraan strategis dengan industri, serta pengembangan inovasi yang berorientasi pada kebutuhan masyarakat dan pembangunan berkelanjutan.',
            ],
            'missedCards' => $this->news->latest(4)->values(),
        ]);
    }
}
