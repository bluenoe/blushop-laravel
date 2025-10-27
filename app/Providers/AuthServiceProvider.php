<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [/* ... */];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('admin', fn (User $user) => (bool)$user->is_admin);
    }
}
