<?php

namespace App\Providers;

class RouteServiceProvider
{
    /**
     * The path users are redirected to after authentication.
     * Using a constant keeps Breeze/Jetstream-compatible redirects stable.
     */
    public const HOME = '/admin';
}