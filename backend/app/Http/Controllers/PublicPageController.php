<?php

namespace App\Http\Controllers;

use App\Support\NewsRepository;
use Illuminate\Contracts\View\View;

class PublicPageController extends Controller
{
    public function __construct(
        protected NewsRepository $news,
    ) {
    }

    /**
     * Data shared by every page that renders the slider + sidebar tabs.
     */
    protected function sharedData(): array
    {
        return [
            'featured' => $this->news->featured()->take(3)->values(),
            'latestPosts' => $this->news->latest(4),
            'popularPosts' => $this->news->popular(4),
            'trendingPosts' => $this->news->popular(4),
            'missedCards' => $this->news->latest(4),
        ];
    }

    /**
     * Landing page.
     */
    public function index(): View
    {
        return view('dashboard', array_merge($this->sharedData(), [
            'page' => 'home',
            'homePosts' => $this->news->published(),
        ]));
    }

    /**
     * Full news article.
     */
    public function show(string $slug): View
    {
        $post = $this->news->find($slug);

        abort_if($post === null || ! ($post['published'] ?? true), 404);

        $this->news->incrementViews($slug);

        return view('berita-detail', [
            'page' => 'home',
            'post' => $post,
            'related' => $this->news->related($post),
            'latestPosts' => $this->news->latest(4),
        ]);
    }

    /**
     * Editorial pages driven by $page: profil, informasi, hki, publikasi, â€¦
     */
    public function page(string $page): View
    {
        return view('dashboard', array_merge($this->sharedData(), [
            'page' => $page,
            'homePosts' => $this->news->published(),
        ]));
    }

    public function profil(): View
    {
        return $this->page('profil');
    }

    public function informasi(): View
    {
        return $this->page('informasi');
    }

    public function penelitian(): View
    {
        return $this->page('penelitian');
    }

    public function publikasi(): View
    {
        return $this->page('publikasi');
    }

    public function hki(): View
    {
        return $this->page('hki');
    }

    public function statistik(): View
    {
        return $this->page('statistik');
    }

    public function berdampak(): View
    {
        return $this->page('berdampak');
    }

    public function tahun2024(): View
    {
        return $this->page('tahun2024');
    }

    public function tahun2025(): View
    {
        return $this->page('tahun2025');
    }

    public function tahun2026(): View
    {
        return $this->page('tahun2026');
    }

    /**
     * Annual report page. The paragraphs and metadata live here so the React
     * page is a pure renderer â€” move them to a repository or database later
     * without touching the front end.
     */
    public function laporanTahunan(): View
    {
        return view('laporan-tahunan', array_merge($this->sharedData(), [
            'page' => 'home',
            'reportYear' => '2025',
            'reportFile' => null,
        ]));
    }
}

