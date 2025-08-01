<?php

namespace App\Repositories\Entities\Document;

use App\Models\Document;
use App\Repositories\Contracts\Document\IDocumentRepository;

class DocumentRepository implements IDocumentRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Document();
    }
    
    public function allUserDocuments(array $params = [])
    {
        if (!isset($params['search'])) {
            return $this->model
                ->where('user_id', $params['user_id']);
        }

        return $this->model->where(function($query) use ($params) {
                $query->where('user_id', $params['user_id']);

                $query->where('name', 'like', "%{$params['search']}%")
                    ->orWhere('description', 'like', "%{$params['search']}%")
                    ->orWhereHas('user', function($q) use ($params) {
                        $q->where('cpf', 'like', "%{$params['search']}%")
                          ->orWhere('name', 'like', "%{$params['search']}%")
                          ->orWhere('role', 'like', "%{$params['search']}%");
                    });
            });
    }

    public function findDocumentById(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $params = [])
    {
        if (empty($params)) {
            return null;
        }

        if (!isset($params['user_id'])) {
            return null;
        }

        try {
            return $this->model->create($params);
        } catch (\Throwable $th) {
            \Log::info($th->getMessage());
            return null;
        }
    }

    public function update(int $id)
    {
        if (is_null($id)) {
            return null;
        }

        $document = $this->find($id);

        if (is_null($document)) {
            return null;
        }

        $document->update($data);
        return $document;
    }

    public function delete($id)
    {
        if (is_null($id)) {
            return null;
        }

        $document = $this->find($id);

        if (is_null($document)) {
            return null;
        }

        return $document->delete();
    }

}