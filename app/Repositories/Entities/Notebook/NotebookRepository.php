<?php

namespace App\Repositories\Entities\Notebook;

use App\Models\Notebook;
use App\Repositories\Contracts\Notebook\INotebookRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

class NotebookRepository implements INotebookRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Notebook();
    }
    
    public function allNotebooks(array $params = []): Builder
    {
        $query = $this->model::query()
            ->select([
                'id', 'brand', 'model', 'serial_number',
                'processor', 'memory', 'disk', 'price', 'price_string'
            ]);

        if (isset($params['search'])) {
            $search = $params['search'];

            $query->where(function (Builder $q) use ($search) {
                $q->where('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('model');
    }

    public function findNotebookById(int $id): ?Notebook
    {
        try {
            return $this->model->findOrFail($id);
        } catch (\Throwable $th) {
            \Log::info($th->getMessage());
            return null;
        }
    }

    public function create(array $params = []): ?Notebook
    {
        if (empty($params)) {
            return null;
        }

        try {
            return $this->model->create($params);
        } catch (\Throwable $th) {
            \Log::info($th->getMessage());
            return null;
        }
    }

    public function update(?int $id, array $data = []): ?Notebook
    {
        if (is_null($id) || empty($data)) {
            return null;
        }

        try {
            $notebook = $this->model->find($id);
            if (is_null($notebook)) {
                return null;
            }

            $notebook->update($data);
            return $notebook;
        } catch (\Throwable $th) {
            \Log::info($th->getMessage());
            return null;
        }
    }

    public function delete($id): bool
    {
        if (is_null($id)) {
            return false;
        }

        $notebook = $this->findNotebookById(
                $id
            );

        if (is_null($notebook)) {
            return false;
        }

        return $notebook->delete();
    }

}