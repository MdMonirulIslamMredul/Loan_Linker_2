<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\LogoSetting;
use App\Models\AboutSetting;

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
        // Share logo settings with all views
        View::composer('*', function ($view) {
            $view->with('logoSettings', LogoSetting::settings());
            $view->with('aboutSettings', AboutSetting::settings());
        });
    }
}
