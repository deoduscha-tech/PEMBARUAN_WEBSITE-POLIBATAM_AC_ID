<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

class SiteContentRepository
{
    public function get(string $key, mixed $default = null): mixed
    {
        $value = DB::table('site_contents')->where('key', $key)->value('value');

        return $value === null ? $default : json_decode($value, true);
    }

    public function put(string $key, mixed $value): void
    {
        DB::table('site_contents')->updateOrInsert(
            ['key' => $key],
            ['value' => json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), 'updated_at' => now(), 'created_at' => now()],
        );
    }
}
