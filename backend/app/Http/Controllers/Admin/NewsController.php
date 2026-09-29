<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\NewsRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __construct(
        protected NewsRepository $news,
    ) {}

    /**
     * Workspace overview: counters and the most recent posts.
     */
    public function dashboard(): View
    {
        $all = $this->news->all();

        return view('admin.dashboard', [
            'stats' => [
                'total' => $all->count(),
                'published' => $all->where('published', true)->count(),
                'draft' => $all->where('published', false)->count(),
                'featured' => $all->where('featured', true)->count(),
                'views' => (int) $all->sum('views'),
            ],
            'recent' => $all->take(5),
            'popular' => $this->news->popular(5),
        ]);
    }

    /**
     * Full news list with optional search and status filter.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q'));
        $status = (string) $request->query('status', 'all');

        $posts = $this->news->all();

        if ($search !== '') {
            $needle = mb_strtolower($search);

            $posts = $posts->filter(fn(array $post) => str_contains(mb_strtolower($post['title']), $needle)
                || str_contains(mb_strtolower((string) $post['excerpt']), $needle)
                || str_contains(mb_strtolower((string) $post['category']), $needle));
        }

        if ($status === 'published') {
            $posts = $posts->where('published', true);
        } elseif ($status === 'draft') {
            $posts = $posts->where('published', false);
        } elseif ($status === 'featured') {
            $posts = $posts->where('featured', true);
        }

        return view('admin.berita.index', [
            'posts' => $posts->values(),
            'search' => $search,
            'status' => $status,
        ]);
    }

    public function create(): View
    {
        return view('admin.berita.form', [
            'post' => null,
            'categories' => $this->categoryOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $this->news->create($data);

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita "' . $data['title'] . '" berhasil ditambahkan.');
    }

    public function edit(int $id): View
    {
        $post = $this->news->findById($id);

        abort_if($post === null, 404);

        return view('admin.berita.form', [
            'post' => $post,
            'categories' => $this->categoryOptions(),
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $data = $this->validated($request);

        $updated = $this->news->update($id, $data);

        abort_if($updated === null, 404);

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita "' . $data['title'] . '" berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $post = $this->news->findById($id);

        abort_if($post === null, 404);

        $this->news->delete($id);

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita "' . $post['title'] . '" telah dihapus.');
    }

    // -------------------------------------------------------------
    // Internals
    // -------------------------------------------------------------

    protected function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:60'],
            'author' => ['nullable', 'string', 'max:80'],
            'date' => ['required', 'date'],
            'image' => ['nullable', 'string', 'max:500'],
            'excerpt' => ['nullable', 'string', 'max:600'],
            'body' => ['required', 'string'],
            'published' => ['nullable', 'boolean'],
            'featured' => ['nullable', 'boolean'],
        ], [
            'title.required' => 'Judul berita wajib diisi.',
            'category.required' => 'Kategori wajib dipilih.',
            'date.required' => 'Tanggal terbit wajib diisi.',
            'body.required' => 'Isi berita wajib diisi.',
        ]);

        $data['published'] = $request->boolean('published');
        $data['featured'] = $request->boolean('featured');
        $data['author'] = $data['author'] ?: 'P3M';

        return $data;
    }

    /**
     * Categories offered in the form, including any already in use.
     */
    protected function categoryOptions(): array
    {
        $defaults = ['Informasi', 'Kegiatan', 'Pengumuman', 'Prestasi', 'Kerjasama'];

        return $this->news->categories()
            ->merge($defaults)
            ->unique()
            ->sort()
            ->values()
            ->all();
    }
}
