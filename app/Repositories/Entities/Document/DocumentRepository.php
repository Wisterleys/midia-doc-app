<?php

namespace App\Repositories\Entities\Document;

use App\Models\Document;
use App\Repositories\Contracts\Document\IDocumentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

class DocumentRepository implements IDocumentRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Document();
    }
    
    public function allUserDocuments(array $params = []): ?Builder
    {
        $query = $this->model::select([
            'documents.id', 'documents.employee_id', 'documents.notebook_id', 'documents.local', 'documents.date',
            'employees.name as employee_name', 'employees.cpf as employee_cpf', 'employees.role as employee_role',
            'notebooks.brand as notebook_brand', 'notebooks.model as notebook_model', 'notebooks.serial_number as notebook_serial_number'
        ]);

        if (!isset($params['user_id'])) {
            return null;
        }

        $query->whereHas('employee.user', function (Builder $q) use ($params) {
                $q->where('id', $params['user_id']);
        });

        $query->join('employees', 'documents.employee_id', '=', 'employees.id')
              ->join('notebooks', 'documents.notebook_id', '=', 'notebooks.id');
        
        if (isset($params['search'])) {
            $search_term = $params['search'];

            $query->where(function (Builder $q) use ($search_term) {
                $q->where('local', 'like', "%{$search_term}%")
                  ->orWhere(function (Builder $date_query) use ($search_term) {
                      $date_query->whereDate('date', $search_term);
                    })
                    ->orWhereHas('notebook', function (Builder $notebook_query) use ($search_term) {
                        $notebook_query->where('brand', 'like', "%{$search_term}%")
                                       ->orWhere('model', 'like', "%{$search_term}%")
                                       ->orWhere('serial_number', 'like', "%{$search_term}%");
                    })
                    ->orWhereHas('employee', function (Builder $employee_query) use ($search_term) {
                        $employee_query->where('cpf', 'like', "%{$search_term}%")
                                      ->orWhere('name', 'like', "%{$search_term}%")
                                      ->orWhere('role', 'like', "%{$search_term}%");
                  });
            });
        }

        $query->orderBy('documents.date', 'desc');
        $query->orderBy('documents.id', 'desc');

        return $query;
    }

    public function findDocumentById(int $id)
    {
        try {
            return $this->model->findOrFail($id);
        } catch (\Throwable $th) {
            return null;
        }
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

    public function delete($id): bool
    {
        if (is_null($id)) {
            return false;
        }

        $document = $this->findDocumentById(
                $id
            );

        if (is_null($document)) {
            return false;
        }

        return $document->delete();
    }

}