<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

/**
 * Pengaturan situs (key/value) yang dapat diubah dari panel admin.
 *
 * Nilai disimpan di tabel `settings`. Kalau sebuah key belum pernah disimpan,
 * dipakai nilai bawaan di DEFAULT_SETTINGS sehingga tampilan tetap normal.
 */
class SiteSettings
{
    /** Pengaturan yang tampil di beranda + nilai bawaannya. */
    public const DEFAULT_SETTINGS = [
        'ticker_label' => 'Latest Post',
        'ticker_count' => '5',
        'home_posts_count' => '5',
        'missed_title' => 'You missed',
        'missed_count' => '4',
        'slider_title' => 'Berita Unggulan',
    ];

    /** Label yang ditampilkan di panel admin. */
    public const LABELS = [
        'ticker_label' => ['Teks label ticker beranda', 'text'],
        'ticker_count' => ['Jumlah berita di ticker', 'number'],
        'home_posts_count' => ['Jumlah berita di daftar beranda', 'number'],
        'missed_title' => ['Judul blok "You missed"', 'text'],
        'missed_count' => ['Jumlah kartu "You missed"', 'number'],
        'slider_title' => ['Judul slider beranda', 'text'],
    ];

    public static function all(): array
    {
        $stored = [];

        try {
            $stored = DB::table('settings')->pluck('value', 'key')->all();
        } catch (\Throwable $e) {
            // Tabel belum dibuat (migrasi belum jalan) — pakai nilai bawaan.
        }

        $values = [];

        foreach (self::DEFAULT_SETTINGS as $key => $default) {
            $values[$key] = array_key_exists($key, $stored) && $stored[$key] !== null
                ? (string) $stored[$key]
                : $default;
        }

        return $values;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return self::all()[$key] ?? $default;
    }

    public static function put(array $values): array
    {
        foreach ($values as $key => $value) {
            if (! array_key_exists($key, self::DEFAULT_SETTINGS)) {
                continue;
            }

            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                ['value' => (string) $value, 'updated_at' => now(), 'created_at' => now()]
            );
        }

        return self::all();
    }
}
