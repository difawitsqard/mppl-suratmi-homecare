<?php

namespace App\Providers;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layouts.partials.dashboard.sidebar', function ($view) {
            $roles = Role::pluck('name');
            $view->with('userRoles', $roles);
        });
    }
}
