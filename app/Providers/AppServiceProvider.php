<?php

namespace App\Providers;

use App\Models\ApplicationSetting;
use App\Models\LandingSetting;
use Illuminate\Support\Facades\View;
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
        try {
            View::share('setting', ApplicationSetting::first());
            View::share('landingSetting', LandingSetting::first());
        } catch (\Exception $e) {
            \Log::error($e);
        }
    }
}
