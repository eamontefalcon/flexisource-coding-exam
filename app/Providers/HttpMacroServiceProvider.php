<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class HttpMacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Register the 'customer' HTTP macro
        Http::macro('customer', function () {
            return Http::withHeaders([
                'accept' => 'application/json',
            ])->baseUrl(config('customer.base_url'));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
