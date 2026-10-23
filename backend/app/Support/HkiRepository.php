<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

class HkiRepository
{
    public function all(): array
    {
        $years = [];
        foreach (DB::table('hki_years')->orderByDesc('year')->get() as $row) {
            $records = json_decode($row->records, true) ?: [];
            $records['views'] = (int) $row->views;
            $years[(int) $row->year] = $records;
        }

        return $years;
    }

    public function find(int $year): ?array
    {
        $row = DB::table('hki_years')->where('year', $year)->first();
        if (!$row) return null;

        $records = json_decode($row->records, true) ?: [];
        $records['views'] = (int) $row->views;

        return $records;
    }

    public function saveYear(int $year, array $data): void
    {
        $views = (int) ($data['views'] ?? 0);
        unset($data['views']);
        DB::table('hki_years')->updateOrInsert(
            ['year' => $year],
            ['records' => json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), 'views' => $views, 'updated_at' => now(), 'created_at' => now()],
        );
    }

    public function deleteYear(int $year): bool
    {
        return DB::table('hki_years')->where('year', $year)->delete() > 0;
    }
}
