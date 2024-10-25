<?php

namespace App\Providers;

use App\Models\ApplicationSetting;
use App\Models\LandingSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

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

        RateLimiter::for('send-otp', function (Request $request) {
            return Limit::perMinute(1)->by($request->input('phone') ?: $request->ip());
        });
    }
}
