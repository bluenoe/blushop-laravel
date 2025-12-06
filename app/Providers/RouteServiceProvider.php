<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path users are redirected to after authentication.
     * Using a constant keeps Breeze/Jetstream-compatible redirects stable.
     */
    public const HOME = '/';
}
