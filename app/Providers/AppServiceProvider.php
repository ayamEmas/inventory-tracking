<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('components.sidebar', function ($view) {
            if (auth()->check()) {
                $pendingCount = \App\Models\Inventory::where('check', 0)->count();
                $view->with('sidebarPendingCount', $pendingCount);
            }
        });
    }
}
