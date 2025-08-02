<?php

namespace App\Observers;

use App\Models\Accessory;

class AccessoryObserver
{
    /**
     * Handle the Accessory "created" event.
     */
    public function created(Accessory $accessory): void
    {
        //
    }

    /**
     * Handle the Accessory "updated" event.
     */
    public function updated(Accessory $accessory): void
    {
        //
    }

    /**
     * Handle the Accessory "deleted" event.
     */
    public function deleted(Accessory $accessory): void
    {
        //
    }

    /**
     * Handle the Accessory "restored" event.
     */
    public function restored(Accessory $accessory): void
    {
        //
    }

    /**
     * Handle the Accessory "force deleted" event.
     */
    public function forceDeleted(Accessory $accessory): void
    {
        //
    }
}
