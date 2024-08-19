<?php

namespace App\Providers;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
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
            /** @var \App\Models\User $currentUser */
            $currentUser = Auth::user();
            $roles = Role::pluck('name')->filter(function ($role) use ($currentUser) {
                return $role !== 'superadmin' || $currentUser->hasRole('superadmin');
            });
            $view->with('userRoles', $roles);
        });
    }
}
