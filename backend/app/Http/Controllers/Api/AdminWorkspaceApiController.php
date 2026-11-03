<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Support\NewsRepository;
use App\Support\SiteSettings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Data untuk dashboard admin di front end Next.js (/admin).
 *
 *   GET  /api/admin/berita      -> SEMUA berita (termasuk draf) untuk dikelola
 *   GET  /api/admin/ringkasan   -> angka ringkas untuk kartu dashboard
 *   GET  /api/admin/pengaturan  -> pengaturan beranda + label
 *   PUT  /api/admin/pengaturan  -> simpan pengaturan beranda
 *
 * Semua endpoint menuntut token login yang sah.
 */
class AdminWorkspaceApiController extends Controller
{
    public function __construct(
        protected NewsRepository $news,
    ) {}

    /**
     * GET /api/admin/berita
     */
    public function berita(Request $request): JsonResponse
    {
        if (($admin = $this->admin($request)) === null) {
            return $this->unauthorized();
        }

        $posts = $this->news->all()->map(fn(array $post) => [
            'id' => $post['id'],
            'title' => $post['title'],
            'slug' => $post['slug'],
            'category' => $post['category'],
            'author' => $post['author'],
            'date' => $this->normalizeDate($post['date'] ?? ''),
            'image' => $post['image'] ?? '',
            'excerpt' => $post['excerpt'] ?? '',
            'body' => $post['body'] ?? '',
            'featured' => $post['featured'],
            'published' => $post['published'],
            'show_in_slider' => $post['show_in_slider'] ?? true,
            'show_in_missed' => $post['show_in_missed'] ?? true,
            'sort_order' => $post['sort_order'] ?? 0,
            'views' => $post['views'],
        ])->values();

        return response()->json([
            'data' => $posts,
            'meta' => [
                'total' => $posts->count(),
                'published' => $posts->where('published', true)->count(),
                'draft' => $posts->where('published', false)->count(),
                'featured' => $posts->where('featured', true)->count(),
                'categories' => $this->news->categories()->values(),
                'admin' => $admin,
            ],
        ]);
    }

    /**
     * GET /api/admin/ringkasan
     */
    public function ringkasan(Request $request): JsonResponse
    {
        if ($this->admin($request) === null) {
            return $this->unauthorized();
        }

        $posts = $this->news->all();

        $perCategory = $posts
            ->groupBy('category')
            ->map(fn($group, $category) => [
                'category' => $category,
                'total' => $group->count(),
                'published' => $group->where('published', true)->count(),
            ])
            ->values();

        $terpopuler = $posts
            ->sortByDesc('views')
            ->take(5)
            ->map(fn(array $post) => [
                'id' => $post['id'],
                'title' => $post['title'],
                'slug' => $post['slug'],
                'views' => $post['views'],
            ])
            ->values();

        return response()->json([
            'data' => [
                'berita' => [
                    'total' => $posts->count(),
                    'published' => $posts->where('published', true)->count(),
                    'draft' => $posts->where('published', false)->count(),
                    'featured' => $posts->where('featured', true)->count(),
                    'slider' => $posts->where('show_in_slider', true)->count(),
                    'missed' => $posts->where('show_in_missed', true)->count(),
                    'total_views' => (int) $posts->sum('views'),
                ],
                'per_kategori' => $perCategory,
                'terpopuler' => $terpopuler,
            ],
        ]);
    }

    /**
     * GET /api/admin/pengaturan
     */
    public function pengaturan(Request $request): JsonResponse
    {
        if ($this->admin($request) === null) {
            return $this->unauthorized();
        }

        return response()->json([
            'data' => SiteSettings::all(),
            'labels' => collect(SiteSettings::LABELS)
                ->map(fn(array $meta, string $key) => ['key' => $key, 'label' => $meta[0], 'type' => $meta[1]])
                ->values(),
        ]);
    }

    /**
     * PUT /api/admin/pengaturan
     */
    public function simpanPengaturan(Request $request): JsonResponse
    {
        if ($this->admin($request) === null) {
            return $this->unauthorized();
        }

        $payload = $request->validate([
            'ticker_label' => ['nullable', 'string', 'max:60'],
            'ticker_count' => ['nullable', 'integer', 'min:1', 'max:20'],
            'home_posts_count' => ['nullable', 'integer', 'min:1', 'max:20'],
            'missed_title' => ['nullable', 'string', 'max:60'],
            'missed_count' => ['nullable', 'integer', 'min:1', 'max:12'],
            'slider_title' => ['nullable', 'string', 'max:60'],
            'tab_latest' => ['nullable', 'string', 'max:30'],
            'tab_popular' => ['nullable', 'string', 'max:30'],
            'tab_trending' => ['nullable', 'string', 'max:30'],
            'read_more_label' => ['nullable', 'string', 'max:40'],
            'footer_title' => ['nullable', 'string', 'max:80'],
            'footer_text' => ['nullable', 'string', 'max:160'],
        ]);

        $saved = SiteSettings::put(array_filter($payload, fn($v) => $v !== null && $v !== ''));

        return response()->json([
            'message' => 'Pengaturan beranda disimpan.',
            'data' => $saved,
        ]);
    }

    protected function admin(Request $request): ?array
    {
        return AuthApiController::adminFromToken($request->header('Authorization'));
    }

    protected function unauthorized(): JsonResponse
    {
        return response()->json(['message' => 'Tidak memiliki akses.'], 401);
    }

    /** Tanggal disimpan sebagai date/datetime — kirim YYYY-MM-DD untuk input form. */
    protected function normalizeDate(string $value): string
    {
        if ($value === '') {
            return '';
        }

        $timestamp = strtotime($value);

        return $timestamp ? date('Y-m-d', $timestamp) : $value;
    }
}
