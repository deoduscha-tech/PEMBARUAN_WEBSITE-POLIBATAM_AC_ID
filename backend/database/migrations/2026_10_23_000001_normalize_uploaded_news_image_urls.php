<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('news_posts')->where('image', 'like', '%/storage/news/%')
            ->orderBy('id')
            ->get(['id', 'image'])
            ->each(function (object $post): void {
                $path = parse_url((string) $post->image, PHP_URL_PATH);
                if (is_string($path) && str_starts_with($path, '/storage/news/')) {
                    DB::table('news_posts')->where('id', $post->id)->update(['image' => $path]);
                }
            });
    }

    public function down(): void
    {
        // Uploaded image paths are intentionally kept portable across hosts.
    }
};
