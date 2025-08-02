<?php

namespace App\Repositories\Contracts\Notebook;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Notebook;

interface INotebookRepository
{
    public function allNotebooks(array $params = []): Builder;
    public function findNotebookById(int $id): ?Notebook;
    public function create(array $params = []): ?Notebook;
    public function update(?int $id, array $data = []): ?Notebook;
    public function delete($id): bool;
}
