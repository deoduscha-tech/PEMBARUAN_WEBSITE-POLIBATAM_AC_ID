<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

/**
 * Autentikasi admin untuk front end Next.js.
 *
 * Berbeda dengan AuthController (yang memakai session + Blade), controller ini
 * mengembalikan token sederhana supaya React bisa menyimpannya dan mengirimnya
 * lewat header Authorization pada setiap permintaan tulis.
 *
 *   POST   /api/auth/login   -> { token, name }
 *   DELETE /api/auth/login   -> hapus token
 *   GET    /api/auth/me      -> data admin yang sedang masuk
 */
class AuthApiController extends Controller
{
    /** Lima percobaan per menit, sama seperti panel Blade. */
    protected const MAX_ATTEMPTS = 5;

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $key = $this->throttleKey($request);

        if (RateLimiter::tooManyAttempts($key, self::MAX_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($key);

            return response()->json([
                'message' => "Terlalu banyak percobaan masuk. Coba lagi dalam {$seconds} detik.",
            ], 429);
        }

        $expectedUser = (string) config('admin.username');
        $expectedPass = (string) config('admin.password');

        $matches = hash_equals($expectedUser, $credentials['username'])
            && hash_equals($expectedPass, $credentials['password']);

        if (! $matches) {
            RateLimiter::hit($key, 300);

            return response()->json([
                'message' => 'Nama pengguna atau kata sandi tidak sesuai.',
            ], 401);
        }

        RateLimiter::clear($key);

        // Token sederhana: cukup untuk tugas, bisa diganti JWT/Sanctum nanti.
        $token = $this->makeToken($expectedUser);

        return response()->json([
            'message' => 'Login berhasil.',
            'token' => $token,
            'name' => (string) config('admin.name'),
            'username' => $expectedUser,
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        $admin = $this->adminFromRequest($request);

        if ($admin === null) {
            return response()->json(['message' => 'Tidak memiliki akses.'], 401);
        }

        return response()->json(['data' => $admin]);
    }

    public function logout(): JsonResponse
    {
        // Token bersifat stateless — front end cukup menghapusnya dari storage.
        return response()->json(['message' => 'Anda telah keluar.']);
    }

    /**
     * Buat token bertanda tangan: ">.<tanda tangan>".
     */
    protected function makeToken(string $username): string
    {
        $payload = base64_encode(json_encode([
            'username' => $username,
            'issued_at' => now()->timestamp,
        ]));

        return $payload . '.' . hash_hmac('sha256', $payload, $this->secret());
    }

    /**
     * Baca admin dari header Authorization.
     * Dipakai juga oleh NewsApiController saat memeriksa izin tulis.
     */
    public static function adminFromToken(?string $header): ?array
    {
        if (! $header || ! str_starts_with($header, 'Bearer ')) {
            return null;
        }

        $token = substr($header, 7);
        $parts = explode('.', $token);

        if (count($parts) !== 2) {
            return null;
        }

        [$payload, $signature] = $parts;

        $secret = (string) config('app.key', 'p3m-api-secret');

        if (! hash_equals(hash_hmac('sha256', $payload, $secret), $signature)) {
            return null;
        }

        $data = json_decode(base64_decode($payload), true);

        if (! is_array($data) || ! isset($data['username'])) {
            return null;
        }

        return [
            'username' => $data['username'],
            'name' => (string) config('admin.name'),
        ];
    }

    protected function adminFromRequest(Request $request): ?array
    {
        return static::adminFromToken($request->header('Authorization'));
    }

    protected function secret(): string
    {
        return (string) config('app.key', 'p3m-api-secret');
    }

    protected function throttleKey(Request $request): string
    {
        return Str::transliterate(
            Str::lower((string) $request->input('username')) . '|' . $request->ip()
        );
    }
}