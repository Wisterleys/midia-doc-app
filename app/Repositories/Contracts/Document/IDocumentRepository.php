<?php

namespace App\Repositories\Contracts\Document;

interface IDocumentRepository
{
    public function allUserDocuments(array $params = []);
    public function findDocumentById(int $id);
    public function create(array $params = []);
    public function update(int $id);
    public function delete($id);
}
