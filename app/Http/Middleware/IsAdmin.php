<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra: Đã đăng nhập CHƯA? và CÓ PHẢI ADMIN KHÔNG?
        // Giả sử trong bảng users bà có cột 'is_admin' (boolean) hoặc 'role' (string)
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.'); // Chặn ngay
        }

        return $next($request);
    }
}
