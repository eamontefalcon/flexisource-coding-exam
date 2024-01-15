<?php

namespace App\Providers;

use App\Services\Customer\CustomerInterface;
use App\Services\Customer\CustomerService;
use Illuminate\Support\ServiceProvider;

class CustomerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CustomerInterface::class, function () {
            return new CustomerService();
        });
    }
}
