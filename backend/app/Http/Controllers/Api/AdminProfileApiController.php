<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Support\NewsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Data untuk halaman "Profil Admin" dan panel notifikasi di topbar.
 *
 *   GET  /api/admin/profil-admin   -> info akun + statistik aktivitas
 *   PUT  /api/admin/profil-admin   -> ubah nama tampilan
 *   POST /api/admin/ganti-sandi    -> ganti kata sandi (minimal 8 karakter)
 *   GET  /api/admin/notifikasi     -> daftar pemberitahuan terkini
 *
 * Semua endpoint menuntut token login yang sah.
 */
class AdminProfileApiController extends Controller
{
    public function __construct(
        protected NewsRepository $news,
    ) {}

    /**
     * GET /api/admin/profil-admin
     */
    public function show(Request $request): JsonResponse
    {
        $admin = $this->admin($request);

        if ($admin === null) {
            return $this->unauthorized();
        }

        $posts = $this->news->all();
        $draft = $posts->where('published', false);

        return response()->json([
            'data' => [
                'username' => $admin['username'],
                'name' => $this->displayName($admin['username']),
                'role' => 'Administrator',
                'avatar_initial' => strtoupper(mb_substr($this->displayName($admin['username']), 0, 1)),
                'stats' => [
                    'total_berita' => $posts->count(),
                    'terbit' => $posts->where('published', true)->count(),
                    'draft' => $draft->count(),
                    'dibaca' => (int) $posts->sum('views'),
                ],
                // Ringkasan hal yang perlu perhatian admin.
                'perhatian' => [
                    'draft' => $draft->count(),
                    'hki_tahun' => $this->countHkiYears(),
                    'publikasi_tahun' => $this->countPublikasiYears(),
                ],
                'terakhir_masuk' => $this->lastLogin($admin['username']),
            ],
        ]);
    }

    /**
     * PUT /api/admin/profil-admin
     *
     * Hanya nama tampilan yang bisa diubah di sini; kredensial tetap di .env.
     */
    public function update(Request $request): JsonResponse
    {
        $admin = $this->admin($request);

        if ($admin === null) {
            return $this->unauthorized();
        }

        $payload = $request->validate([
            'name' => ['required', 'string', 'max:60'],
        ]);

        // Simpan sebagai pengaturan tampilan di tabel settings.
        DB::table('settings')->updateOrInsert(
            ['key' => 'admin_display_name'],
            ['value' => $payload['name'], 'updated_at' => now(), 'created_at' => now()]
        );

        return response()->json([
            'message' => 'Nama tampilan diperbarui.',
            'data' => ['name' => $payload['name']],
        ]);
    }

    /**
     * POST /api/admin/ganti-sandi
     *
     * Kata sandi dibandingkan dengan nilai di config (ADMIN_PASSWORD).
     * Karena proyek memakai kredensial di .env, sandi baru tidak bisa ditulis
     * permanen dari sini — perubahan dilakukan oleh pemilik server.
     */
    public function gantiSandi(Request $request): JsonResponse
    {
        $admin = $this->admin($request);

        if ($admin === null) {
            return $this->unauthorized();
        }

        $payload = $request->validate([
            'sandi_lama' => ['required', 'string'],
            'sandi_baru' => ['required', 'string', 'min:8'],
            'konfirmasi' => ['required', 'string', 'same:sandi_baru'],
        ]);

        if (! hash_equals((string) config('admin.password'), $payload['sandi_lama'])) {
            return response()->json(['message' => 'Kata sandi lama tidak sesuai.'], 422);
        }

        return response()->json([
            'message' => 'Kata sandi lama terverifikasi. Untuk keamanan, kata sandi baru '
                . 'disimpan di berkas backend/.env (ADMIN_PASSWORD) oleh pemilik server.',
            'data' => ['terverifikasi' => true],
        ]);
    }

    /**
     * GET /api/admin/notifikasi
     *
     * Pemberitahuan dirakit dari keadaan data saat ini: draf yang belum terbit,
     * tahun HKI/publikasi yang belum punya data, dan berita terbaru.
     */
    public function notifikasi(Request $request): JsonResponse
    {
        if ($this->admin($request) === null) {
            return $this->unauthorized();
        }

        $posts = $this->news->all();
        $draft = $posts->where('published', false);
        $items = [];

        if ($draft->count() > 0) {
            $items[] = [
                'type' => 'draft',
                'title' => $draft->count() . ' berita masih berstatus draf',
                'desc' => 'Belum tampil di website. Periksa dan terbitkan bila siap.',
                'href' => '/admin/berita',
                'time' => 'Perlu tindakan',
                'tone' => 'amber',
            ];
        }

        $terbaru = $posts->sortByDesc('date')->take(3);

        foreach ($terbaru as $post) {
            $items[] = [
                'type' => 'berita',
                'title' => 'Berita terbit: ' . $post['title'],
                'desc' => 'Kategori ' . $post['category'],
                'href' => '/admin/berita',
                'time' => $this->formatTanggal((string) $post['date']),
                'tone' => 'blue',
            ];
        }

        $tanpaHki = $this->missingHkiYears();

        if (count($tanpaHki) > 0) {
            $items[] = [
                'type' => 'hki',
                'title' => 'Data HKI belum lengkap',
                'desc' => 'Tahun tanpa data: ' . implode(', ', $tanpaHki) . '.',
                'href' => '/admin/hki',
                'time' => 'Perlu tindakan',
                'tone' => 'violet',
            ];
        }

        return response()->json([
            'data' => $items,
            'meta' => [
                'total' => count($items),
                'belum_dibaca' => count(array_filter($items, fn($i) => $i['time'] === 'Perlu tindakan')),
            ],
        ]);
    }

    // -----------------------------------------------------------------
    // Internals
    // -----------------------------------------------------------------

    protected function admin(Request $request): ?array
    {
        return AuthApiController::adminFromToken($request->header('Authorization'));
    }

    protected function unauthorized(): JsonResponse
    {
        return response()->json(['message' => 'Tidak memiliki akses.'], 401);
    }

    /** "2026-06-15" -> "15 Juni 2026"; nilai tak dikenal dikembalikan apa adanya. */
    protected function formatTanggal(string $value): string
    {
        $timestamp = strtotime($value);

        if ($timestamp === false) {
            return $value;
        }

        $bulan = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
        ];

        return (int) date('j', $timestamp) . ' '
            . $bulan[(int) date('n', $timestamp)] . ' '
            . date('Y', $timestamp);
    }

    protected function displayName(string $fallback): string
    {
        try {
            $name = DB::table('settings')->where('key', 'admin_display_name')->value('value');

            if ($name) {
                return $name;
            }
        } catch (\Throwable $e) {
            // Tabel settings belum ada — lanjut ke nilai bawaan.
        }

        // Sebelum admin pernah mengubah nama, pakai nama dari config.
        return (string) (config('admin.name') ?: $fallback);
    }

    protected function lastLogin(string $username): string
    {
        try {
            $row = DB::table('admin_logins')->where('username', $username)->latest('created_at')->first();

            return $row ? (string) $row->created_at : 'Sesi ini';
        } catch (\Throwable $e) {
            return 'Sesi ini';
        }
    }

    protected function countHkiYears(): int
    {
        try {
            return (int) DB::table('hki_years')->count();
        } catch (\Throwable $e) {
            return 0;
        }
    }

    protected function countPublikasiYears(): int
    {
        try {
            $path = resource_path('data/publikasi.php');

            if (! is_file($path)) {
                return 0;
            }

            $data = require $path;

            return is_array($data) ? count($data) : 0;
        } catch (\Throwable $e) {
            return 0;
        }
    }

    /** Tahun 2017-2025 yang belum punya data HKI. */
    protected function missingHkiYears(): array
    {
        try {
            $ada = DB::table('hki_years')->pluck('year')->map(fn($y) => (int) $y)->all();
        } catch (\Throwable $e) {
            return [];
        }

        $hilang = [];

        for ($year = 2017; $year <= (int) date('Y'); $year++) {
            if (! in_array($year, $ada, true)) {
                $hilang[] = (string) $year;
            }
        }

        return $hilang;
    }
}
