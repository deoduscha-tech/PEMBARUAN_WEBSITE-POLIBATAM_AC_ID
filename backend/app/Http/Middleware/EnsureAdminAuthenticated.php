<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Blocks the admin workspace unless an admin session is present.
 */
class EnsureAdminAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->get(config('admin.session_key'))) {
            return redirect()
                ->route('admin.login')
                ->with('error', 'Silakan masuk terlebih dahulu untuk mengelola berita.');
        }

        return $next($request);
    }
}
