<?php

namespace App\Providers;

use App\Services\Customer\ImportCustomerInterface;
use App\Services\Customer\ImportCustomerService;
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
        $this->app->bind(ImportCustomerInterface::class, function () {
            return new ImportCustomerService();
        });
    }
}
