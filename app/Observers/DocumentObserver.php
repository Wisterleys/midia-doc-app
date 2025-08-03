<?php

namespace App\Observers;

use App\Models\Document;
use App\Models\Accessory;

class DocumentObserver
{
    public function retrieved(Document $model): void
    {
        //
    }

    public function creating(Document $model): void
    {
        //
    }

    public function created(Document $model): void
    {
       //
    }

    public function updating(Document $model): void
    {
        //
    }

    public function deleted(Document $model): void
    {
        //
    }
}