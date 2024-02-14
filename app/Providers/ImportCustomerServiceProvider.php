<?php

namespace App\Providers;

use App\Services\Customer\Api\CustomerImportInterface;
use App\Services\Customer\Api\CustomerImportService;
use Illuminate\Support\ServiceProvider;

class ImportCustomerServiceProvider extends ServiceProvider
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
        $this->app->bind(CustomerImportInterface::class, function () {
            return new CustomerImportService();
        });
    }
}
