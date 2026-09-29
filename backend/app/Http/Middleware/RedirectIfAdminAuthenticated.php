<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Keeps an already signed-in admin away from the login form.
 */
class RedirectIfAdminAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->get(config('admin.session_key'))) {
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}
