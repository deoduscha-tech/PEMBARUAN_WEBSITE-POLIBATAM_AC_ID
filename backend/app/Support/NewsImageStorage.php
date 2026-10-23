<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class NewsImageStorage
{
    public function store(UploadedFile $image): string
    {
        return '/storage/' . $image->store('news', 'public');
    }

    public function delete(?string $url): void
    {
        if (!$url) return;

        $path = parse_url($url, PHP_URL_PATH) ?: '';
        if (!str_starts_with($path, '/storage/news/')) return;

        Storage::disk('public')->delete('news/' . basename($path));
    }
}
