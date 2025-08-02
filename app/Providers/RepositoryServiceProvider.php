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
        // Document
        $this->app->bind(
            \App\Repositories\Contracts\Document\IDocumentRepository::class,
            \App\Repositories\Entities\Document\DocumentRepository::class
        );

        // Employee
        $this->app->bind(
            \App\Repositories\Contracts\Employee\IEmployeeRepository::class,
            \App\Repositories\Entities\Employee\EmployeeRepository::class
        );
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