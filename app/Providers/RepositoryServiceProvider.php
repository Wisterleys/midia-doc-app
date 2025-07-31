<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Product
        $this->app->bind(
            \App\Repositories\Contracts\Product\IProductRepository::class,
            \App\Repositories\Entities\ProductRepository::class
        );
        
        // Person
        $this->app->bind(
            \App\Repositories\Contracts\Person\IPersonRepository::class,
            \App\Repositories\Entities\PersonRepository::class
        );
        
        // Adicione outros bindings de repositories aqui conforme necessário
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}