<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Person;
use App\Observers\PersonObserver;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Person::observe(PersonObserver::class);
    }
}
