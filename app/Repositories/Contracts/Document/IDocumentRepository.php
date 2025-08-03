<?php

namespace App\Repositories\Contracts\Document;

use Illuminate\Database\Eloquent\Builder;

interface IDocumentRepository
{
    public function allUserDocuments(array $params = []): ?Builder;
    public function findDocumentById(int $id);
    public function create(array $params = []);
    public function update(int $id, array $params);
    public function delete($id);
}
