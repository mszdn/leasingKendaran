<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login dulu.');
        }

        if (!in_array(Auth::user()->role, $roles)) {
            return redirect()->route('login')->with('error', 'Anda tidak punya akses.');
        }

        return $next($request);
    }
}
