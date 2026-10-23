<?php

namespace App\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/** Database-backed news store shared by the admin workspace and public pages. */
class NewsRepository
{
    public function all(): Collection
    {
        return DB::table('news_posts')->orderByDesc('published_on')->orderByDesc('id')->get()
            ->map(fn (object $post) => $this->toArray($post));
    }

    public function published(): Collection
    {
        return $this->query()->where('published', true)->orderByDesc('published_on')->orderByDesc('id')->get()->map(fn (object $post) => $this->toArray($post));
    }

    public function featured(): Collection
    {
        return $this->query()->where('published', true)->where('featured', true)->orderByDesc('published_on')->get()->map(fn (object $post) => $this->toArray($post));
    }

    public function popular(int $limit = 4): Collection
    {
        return $this->query()->where('published', true)->orderByDesc('views')->limit($limit)->get()->map(fn (object $post) => $this->toArray($post));
    }

    public function latest(int $limit = 4, ?string $excludeSlug = null): Collection
    {
        $query = $this->query()->where('published', true)->orderByDesc('published_on')->orderByDesc('id');
        if ($excludeSlug !== null) $query->where('slug', '!=', $excludeSlug);

        return $query->limit($limit)->get()->map(fn (object $post) => $this->toArray($post));
    }

    public function find(string $slug): ?array
    {
        $post = DB::table('news_posts')->where('slug', $slug)->first();

        return $post ? $this->toArray($post) : null;
    }

    public function findById(int $id): ?array
    {
        $post = DB::table('news_posts')->where('id', $id)->first();

        return $post ? $this->toArray($post) : null;
    }

    public function related(array $post, int $limit = 3): Collection
    {
        $sameCategory = $this->published()->where('slug', '!=', $post['slug'])
            ->where('category', $post['category'])->take($limit);

        return $sameCategory->count() >= $limit
            ? $sameCategory->values()
            : $this->published()->where('slug', '!=', $post['slug'])->take($limit)->values();
    }

    public function create(array $attributes): array
    {
        $data = $this->normalize($attributes);
        $id = DB::table('news_posts')->insertGetId($data + ['created_at' => now(), 'updated_at' => now()]);

        return $this->findById($id);
    }

    public function update(int $id, array $attributes): ?array
    {
        $existing = $this->findById($id);
        if ($existing === null) return null;

        DB::table('news_posts')->where('id', $id)->update($this->normalize(array_merge($existing, $attributes), $id) + ['updated_at' => now()]);

        return $this->findById($id);
    }

    public function delete(int $id): bool
    {
        return DB::table('news_posts')->where('id', $id)->delete() > 0;
    }

    public function incrementViews(string $slug): void
    {
        DB::table('news_posts')->where('slug', $slug)->increment('views');
    }

    public function categories(): Collection
    {
        return DB::table('news_posts')->whereNotNull('category')->distinct()->orderBy('category')->pluck('category');
    }

    private function query()
    {
        return DB::table('news_posts')->select('id', 'title', 'slug', 'category', 'author', 'published_on as date', 'image', 'excerpt', 'featured', 'views', 'published', 'body');
    }

    private function toArray(object $post): array
    {
        $post = (array) $post;
        $post['date'] = (string) ($post['date'] ?? $post['published_on'] ?? '');
        unset($post['published_on']);
        $post['featured'] = (bool) $post['featured'];
        $post['published'] = (bool) $post['published'];
        $post['views'] = (int) $post['views'];
        $imagePath = parse_url((string) ($post['image'] ?? ''), PHP_URL_PATH);
        if (is_string($imagePath) && str_starts_with($imagePath, '/storage/news/')) {
            $post['image'] = $imagePath;
        }

        return $post;
    }

    private function normalize(array $attributes, ?int $ignoreId = null): array
    {
        $title = trim((string) ($attributes['title'] ?? 'Tanpa judul'));
        $slug = trim((string) ($attributes['slug'] ?? '')) ?: Str::slug($title);
        $base = $slug ?: 'berita';
        $candidate = $base;
        $suffix = 1;
        while (DB::table('news_posts')->where('slug', $candidate)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $candidate = $base . '-' . (++$suffix);
        }

        return [
            'title' => $title,
            'slug' => $candidate,
            'category' => $attributes['category'] ?? 'Informasi',
            'author' => $attributes['author'] ?? 'P3M',
            'published_on' => $attributes['date'] ?? now()->toDateString(),
            'image' => $attributes['image'] ?? '',
            'excerpt' => $attributes['excerpt'] ?? Str::limit(strip_tags((string) ($attributes['body'] ?? '')), 160),
            'featured' => (bool) ($attributes['featured'] ?? false),
            'views' => (int) ($attributes['views'] ?? 0),
            'published' => (bool) ($attributes['published'] ?? true),
            'body' => $attributes['body'] ?? '',
        ];
    }
}
