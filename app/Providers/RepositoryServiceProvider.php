<?php

namespace App\Providers;

use App\Entities\Customer;
use App\Repositories\Customer\CustomerRepository;
use App\Repositories\Customer\CustomerRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * List of Entity Repositories and their interfaces
     */
    private array $repos = [
        [
            'interface' => CustomerRepositoryInterface::class,
            'repository' => CustomerRepository::class,
            'entity' => Customer::class,
        ]
    ];


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
     */
    public function register(): void
    {
         foreach ($this->repos as $repo) {
             $this->app->bind($repo['interface'], fn ($app) => new $repo['repository'] (
                 $app['em'],
                 $app['em']->getClassMetaData($repo['entity'])
             ));
         }
    }
}
