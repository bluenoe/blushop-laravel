<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check() || ! Auth::user()->is_admin) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
