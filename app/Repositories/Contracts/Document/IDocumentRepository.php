<?php

namespace App\Repositories\Contracts\Document;

interface IDocumentRepository
{
    public function all();
    public function findById($id);
    public function create(array $params = []);
    public function update(int $id);
    public function delete($id);
}
