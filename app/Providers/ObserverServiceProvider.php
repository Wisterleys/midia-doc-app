<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


use App\Models\Employee;
use App\Models\Notebook;
use App\Models\Document;
use App\Models\Accessory;
use App\Models\User;

use App\Observers\EmployeeObserver;
use App\Observers\NotebookObserver;
use App\Observers\DocumentObserver;
use App\Observers\AccessoryObserver;
use App\Observers\UserObserver;

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
        Employee::observe(EmployeeObserver::class);
        Notebook::observe(NotebookObserver::class);
        Document::observe(DocumentObserver::class);
        Accessory::observe(AccessoryObserver::class);
        User::observe(UserObserver::class);
    }
}
