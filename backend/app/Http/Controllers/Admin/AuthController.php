<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show the admin sign-in form.
     */
    public function showLogin(): View
    {
        return view('admin.login');
    }

    /**
     * Validate the credentials in config/admin.php and open a session.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $this->ensureIsNotRateLimited($request);

        $expectedUser = (string) config('admin.username');
        $expectedPass = (string) config('admin.password');

        $matches = hash_equals($expectedUser, $credentials['username'])
            && hash_equals($expectedPass, $credentials['password']);

        if (! $matches) {
            RateLimiter::hit($this->throttleKey($request), 300);

            throw ValidationException::withMessages([
                'username' => 'Nama pengguna atau kata sandi tidak sesuai.',
            ]);
        }

        RateLimiter::clear($this->throttleKey($request));

        // A fresh session id guards against fixation.
        $request->session()->regenerate();
        $request->session()->put(config('admin.session_key'), [
            'username' => $expectedUser,
            'name' => config('admin.name'),
            'signed_in_at' => now()->toDateTimeString(),
        ]);

        return redirect()
            ->intended(route('admin.dashboard'))
            ->with('success', 'Selamat datang, ' . config('admin.name') . '.');
    }

    /**
     * Drop the admin session.
     */
    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget(config('admin.session_key'));
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('admin.login')
            ->with('success', 'Anda telah keluar dari workspace admin.');
    }

    /**
     * Five failed attempts per minute is plenty for a single operator.
     */
    protected function ensureIsNotRateLimited(Request $request): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages([
            'username' => "Terlalu banyak percobaan masuk. Coba lagi dalam {$seconds} detik.",
        ]);
    }

    protected function throttleKey(Request $request): string
    {
        return Str::transliterate(Str::lower($request->input('username')) . '|' . $request->ip());
    }
}
