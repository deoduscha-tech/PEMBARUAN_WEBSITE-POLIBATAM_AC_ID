<?php

namespace App\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Flat-file news store.
 *
 * Reads and writes resources/data/berita.php so the admin workspace can do
 * full CRUD without a database. The public API mirrors what an Eloquent
 * repository would expose, so swapping to a model later is a one-file change.
 */
class NewsRepository
{
    public function __construct(
        protected ?string $path = null,
    ) {
        $this->path ??= resource_path('data/berita.php');
    }

    /**
     * Every post, newest first.
     */
    public function all(): Collection
    {
        return collect($this->read())
            ->sortByDesc('date')
            ->values();
    }

    /**
     * Posts the public site may show.
     */
    public function published(): Collection
    {
        return $this->all()
            ->where('published', true)
            ->values();
    }

    public function featured(): Collection
    {
        return $this->published()
            ->where('featured', true)
            ->values();
    }

    public function popular(int $limit = 4): Collection
    {
        return $this->published()
            ->sortByDesc('views')
            ->take($limit)
            ->values();
    }

    public function latest(int $limit = 4, ?string $excludeSlug = null): Collection
    {
        return $this->published()
            ->when($excludeSlug, fn(Collection $c) => $c->where('slug', '!=', $excludeSlug))
            ->take($limit)
            ->values();
    }

    public function find(string $slug): ?array
    {
        return $this->all()->firstWhere('slug', $slug);
    }

    public function findById(int $id): ?array
    {
        return $this->all()->firstWhere('id', $id);
    }

    /**
     * Posts in the same category, falling back to the newest ones.
     */
    public function related(array $post, int $limit = 3): Collection
    {
        $pool = $this->published()->where('slug', '!=', $post['slug']);

        $sameCategory = $pool->where('category', $post['category'])->take($limit);

        if ($sameCategory->count() >= $limit) {
            return $sameCategory->values();
        }

        return $pool->take($limit)->values();
    }

    public function create(array $attributes): array
    {
        $posts = $this->read();

        $post = $this->normalize($attributes, [
            'id' => $this->nextId($posts),
            'views' => 0,
        ]);

        $posts[] = $post;
        $this->write($posts);

        return $post;
    }

    public function update(int $id, array $attributes): ?array
    {
        $posts = $this->read();
        $updated = null;

        foreach ($posts as $index => $post) {
            if ((int) $post['id'] !== $id) {
                continue;
            }

            $updated = $this->normalize($attributes, $post, $id);
            $posts[$index] = $updated;

            break;
        }

        if ($updated !== null) {
            $this->write($posts);
        }

        return $updated;
    }

    public function delete(int $id): bool
    {
        $posts = $this->read();
        $remaining = array_values(array_filter($posts, fn(array $p) => (int) $p['id'] !== $id));

        if (count($remaining) === count($posts)) {
            return false;
        }

        $this->write($remaining);

        return true;
    }

    /**
     * Count a page view for one post.
     */
    public function incrementViews(string $slug): void
    {
        $posts = $this->read();

        foreach ($posts as $index => $post) {
            if ($post['slug'] === $slug) {
                $posts[$index]['views'] = ((int) $post['views']) + 1;

                break;
            }
        }

        $this->write($posts);
    }

    public function categories(): Collection
    {
        return $this->all()->pluck('category')->filter()->unique()->sort()->values();
    }

    // -------------------------------------------------------------
    // Internals
    // -------------------------------------------------------------

    protected function read(): array
    {
        if (! is_file($this->path)) {
            return [];
        }

        $data = require $this->path;

        return is_array($data) ? $data : [];
    }

    protected function write(array $posts): void
    {
        $export = "<?php\n\n"
            . "/**\n"
            . " * Static news store — no database required.\n"
            . " *\n"
            . " * Managed from the admin workspace at /admin/berita.\n"
            . " * Written automatically; edit through the admin UI where possible.\n"
            . " */\n\n"
            . "return " . $this->exportArray($posts, 0) . ";\n";

        file_put_contents($this->path, $export, LOCK_EX);
    }

    /**
     * Fill in defaults and keep the slug unique.
     */
    protected function normalize(array $attributes, array $base = [], ?int $ignoreId = null): array
    {
        $title = trim((string) ($attributes['title'] ?? $base['title'] ?? 'Tanpa judul'));

        $slug = trim((string) ($attributes['slug'] ?? '')) ?: Str::slug($title);

        return array_merge([
            'id' => $base['id'] ?? 0,
            'title' => $title,
            'slug' => $this->uniqueSlug($slug, $ignoreId),
            'category' => $attributes['category'] ?? $base['category'] ?? 'Informasi',
            'author' => $attributes['author'] ?? $base['author'] ?? 'P3M',
            'date' => $attributes['date'] ?? $base['date'] ?? now()->toDateString(),
            'image' => $attributes['image'] ?? $base['image'] ?? '',
            'excerpt' => $attributes['excerpt'] ?? $base['excerpt'] ?? Str::limit(strip_tags((string) ($attributes['body'] ?? '')), 160),
            'featured' => (bool) ($attributes['featured'] ?? $base['featured'] ?? false),
            'views' => (int) ($attributes['views'] ?? $base['views'] ?? 0),
            'published' => (bool) ($attributes['published'] ?? $base['published'] ?? true),
            'body' => $attributes['body'] ?? $base['body'] ?? '',
        ]);
    }

    protected function uniqueSlug(string $slug, ?int $ignoreId = null): string
    {
        $base = $slug !== '' ? $slug : 'berita';
        $candidate = $base;
        $suffix = 1;

        $taken = $this->all()
            ->when($ignoreId, fn(Collection $c) => $c->where('id', '!=', $ignoreId))
            ->pluck('slug')
            ->all();

        while (in_array($candidate, $taken, true)) {
            $candidate = $base . '-' . (++$suffix);
        }

        return $candidate;
    }

    protected function nextId(array $posts): int
    {
        $ids = array_map(fn(array $p) => (int) $p['id'], $posts);

        return $ids === [] ? 1 : max($ids) + 1;
    }

    /**
     * Render a nested array as readable PHP source.
     */
    protected function exportArray(array $array, int $depth): string
    {
        if ($array === []) {
            return '[]';
        }

        $pad = str_repeat('    ', $depth + 1);
        $closePad = str_repeat('    ', $depth);
        $isList = array_is_list($array);

        $lines = [];

        foreach ($array as $key => $value) {
            $prefix = $isList ? '' : var_export($key, true) . ' => ';

            if (is_array($value)) {
                $rendered = $this->exportArray($value, $depth + 1);
            } elseif (is_bool($value)) {
                $rendered = $value ? 'true' : 'false';
            } elseif (is_int($value)) {
                $rendered = (string) $value;
            } elseif (is_string($value) && str_contains($value, "\n")) {
                // Heredoc rules: the body lines and the closing marker must be
                // indented consistently, and the closing marker may not be
                // indented further than the body. Indent both by $pad so the
                // generated file always parses.
                $body = str_replace("\r\n", "\n", $value);
                $indented = str_replace("\n", "\n" . $pad, $body);
                $rendered = "<<<'HTML'\n" . $pad . $indented . "\n" . $pad . 'HTML';
            } else {
                $rendered = var_export((string) $value, true);
            }

            $lines[] = $pad . $prefix . $rendered . ',';
        }

        return "[\n" . implode("\n", $lines) . "\n" . $closePad . ']';
    }
}
