<?php

namespace App\Http\Responses;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse($request): RedirectResponse
    {
        $user = $request->user();

        $target = ($user && ($user->is_admin ?? false))
            ? (Route::has('admin.dashboard') ? route('admin.dashboard') : '/admin')
            : (Route::has('home') ? route('home') : '/');

        return redirect()->intended($target);
    }
}
