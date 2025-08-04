<?php

namespace App\Repositories\Entities\Document;

use App\Models\Document;
use App\Repositories\Contracts\Document\IDocumentRepository;
use App\Repositories\Entities\Notebook\NotebookRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class DocumentRepository implements IDocumentRepository
{
    protected $model;
    protected $notebookRepository;

    public function __construct()
    {
        $this->notebookRepository = new NotebookRepository();
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
                        $employee_query->where(function (Builder $query) use ($search_term) {
                            if (preg_match('/^(\d{3}\.?\d{3}\.?\d{3}-?\d{2}|\d{11})$/', $search_term)) {
                                $formatted_cpf = $this->formatCpfWithMask($search_term);
                                $query->orWhere('cpf', 'like', "%{$formatted_cpf}%");
                            }

                            $query->orWhere('name', 'like', "%{$search_term}%")
                                ->orWhere('role', 'like', "%{$search_term}%");
                        });
                    });

            });
        }

        $query->orderBy('documents.date', 'desc');
        $query->orderBy('documents.id', 'desc');

        return $query;
    }

    public function findDocumentById(int $id, array $with = [])
    {
        try {
            return $this->model->with($with)->findOrFail($id);
        } catch (\Throwable $th) {
            return null;
        }
    }

    public function create(array $params = [])
    {
        DB::beginTransaction();

        try {
            $document = $this->model->create($params);

            if (
                !is_null($document) 
                && isset(
                    $params['notebook_id'],
                    $params['accessories_ids']
                    )
            ) {
                $this->syncAccessoriesToNotebook(
                    $params['notebook_id'], 
                    $params['accessories_ids']
                );
            }

            DB::commit();
            return $document;
        } catch (\Throwable $th) {
            DB::rollBack();
            \Log::error($th->getMessage());
            return null;
        }
    }

    public function update(int $id, array $params)
    {
        DB::beginTransaction();

        try {
            $document = $this->findDocumentById($id);

            if (!$document) {
                return null;
            }

            $document->update($params);

            if (
                isset($document->notebook_id, 
                $params['accessories_ids'])
            ) {
                $this->syncAccessoriesToNotebook(
                    $document->notebook_id, 
                    $params['accessories_ids']
                );
            }

            DB::commit();
            return $document;
        } catch (\Throwable $th) {
            DB::rollBack();
            \Log::error($th->getMessage());
            return null;
        }
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

    protected function syncAccessoriesToNotebook($notebook_id, array $accessories_ids)
    {
        $notebook = $this->notebookRepository
            ->findNotebookById(
                $notebook_id
            );

        if (!is_null($notebook)) {
            $notebook->accessories()->sync($accessories_ids);
        }
    }

    private function formatCpfWithMask(string $cpf): string
    {
        $digitos = preg_replace('/[^0-9]/', '', $cpf);

        if (strlen($digitos) === 11) {
            return substr($digitos, 0, 3) . '.' . 
                substr($digitos, 3, 3) . '.' . 
                substr($digitos, 6, 3) . '-' . 
                substr($digitos, 9, 2);
        }

        return $cpf;
    }
}