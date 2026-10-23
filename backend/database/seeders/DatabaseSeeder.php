<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin'],
            ['name' => 'admin', 'password' => Hash::make('admin123'), 'email_verified_at' => now()],
        );

        $newsPath = resource_path('data/berita.php');
        $posts = is_file($newsPath) ? require $newsPath : [];
        foreach (is_array($posts) ? $posts : [] as $post) {
            DB::table('news_posts')->insertOrIgnore([
                'id' => $post['id'],
                'title' => $post['title'],
                'slug' => $post['slug'],
                'category' => $post['category'] ?? 'Informasi',
                'author' => $post['author'] ?? 'P3M',
                'published_on' => $post['date'] ?? now()->toDateString(),
                'image' => $post['image'] ?? '',
                'excerpt' => $post['excerpt'] ?? '',
                'featured' => (bool) ($post['featured'] ?? false),
                'views' => (int) ($post['views'] ?? 0),
                'published' => (bool) ($post['published'] ?? true),
                'body' => $post['body'] ?? '',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $hkiPath = resource_path('data/hki.php');
        $years = is_file($hkiPath) ? require $hkiPath : [];
        foreach (is_array($years) ? $years : [] as $year => $record) {
            $views = (int) ($record['views'] ?? 0);
            unset($record['views']);
            DB::table('hki_years')->insertOrIgnore([
                'year' => (int) $year,
                'views' => $views,
                'records' => json_encode($record, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        foreach (['publikasi', 'statistik', 'kontak', 'tupoksi'] as $key) {
            $path = resource_path('data/' . $key . '.php');
            if (!is_file($path) || DB::table('site_contents')->where('key', $key)->exists()) continue;

            $value = require $path;
            DB::table('site_contents')->insert([
                'key' => $key,
                'value' => json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
