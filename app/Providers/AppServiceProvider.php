<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
    // app/Providers/AppServiceProvider.php
    public function boot()
    {
        // Force HTTPS untuk ngrok
        if (
            str_contains(request()->getHost(), 'ngrok') ||
            request()->header('x-forwarded-proto') == 'https'
        ) {
            URL::forceScheme('https');
        }

        // Set root URL untuk ngrok
        if (str_contains(request()->getHost(), 'ngrok')) {
            URL::forceRootUrl('https://' . request()->getHost());
        }
    }
}
