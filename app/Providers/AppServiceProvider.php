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
        require_once app_path('Helpers/helpers.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register theme view namespace with standard fallbacks
        // Active theme directories are resolved dynamically by theme_view() helper
        \Illuminate\Support\Facades\View::addNamespace('theme', [
            resource_path('views/themes/default'),
            resource_path('views/frontend'),
        ]);
    }
}
