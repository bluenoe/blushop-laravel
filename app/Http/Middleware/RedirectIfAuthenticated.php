<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  array<int, string|null>  $guards
     */
    public function handle(Request $request, Closure $next, string ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user() ?? $request->user();
                $target = ($user && ($user->is_admin ?? false))
                    ? (Route::has('admin.dashboard') ? route('admin.dashboard') : '/admin')
                    : (Route::has('home') ? route('home') : '/');

                return redirect()->intended($target);
            }
        }

        return $next($request);
    }
}
