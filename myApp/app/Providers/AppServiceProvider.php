<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap application services.
     */
    public function boot(): void
    {
        Gate::define('access-admin', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('access-dokter', function ($user) {
            return $user->role === 'dokter';
        });

        Gate::define('access-pasien', function ($user) {
            return $user->role === 'pasien';
        });
    }
}