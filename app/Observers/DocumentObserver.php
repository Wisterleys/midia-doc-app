<?php

namespace App\Observers;

use App\Models\Document;
use App\Repositories\Contracts\Notebook\INotebookRepository;

class DocumentObserver
{
    protected INotebookRepository $notebookRepository;

    public function __construct(INotebookRepository $notebookRepository)
    {
        $this->notebookRepository = $notebookRepository;
    }

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

    public function deleting(Document $model): void
    {
        if (isset($document->notebook_id)) {
            $notebook = $this->notebookRepository
                ->findNotebookById(
                    $notebook_id
                );

            if (!is_null($notebook)) {
                $notebook->accessories()->sync([]);
            }
        }
    }
}