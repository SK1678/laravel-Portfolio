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
        if (!app()->runningInConsole()) {
            $siteSettings = \App\Models\SiteSetting::first();
            view()->share('siteSettings', $siteSettings);

            $siteOwner = \App\Models\User::where('is_site_owner', true)->first();
            view()->share('siteOwner', $siteOwner);
        }
    }
}
