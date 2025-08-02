<?php

namespace App\Repositories\Entities\Employee;

use App\Models\Employee;
use App\Repositories\Contracts\Employee\IEmployeeRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

class EmployeeRepository implements IEmployeeRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Employee();
    }
    
    public function allUserEmployees(array $params = []): Builder
    {
        $query = $this->model::select([
            'id', 
            'name', 
            'cpf', 
            'role'
        ]);

        if (isset($params['user_id'])) {
            $query->where('user_id', $params['user_id']);
            $query->where('user_id', $params['user_id']);
        }

        if (isset($params['search'])) {
            $search_term = $params['search'];

            $query->where(function (Builder $q) use ($search_term) {
                $q->where('name', 'like', "%{$search_term}%")
                ->orWhere('cpf', 'like', "%{$search_term}%")
                ->orWhere('role', 'like', "%{$search_term}%");
            });
        }

        $query->orderBy('name', 'asc'); // Ou outro campo de ordenação relevante

        return $query;
    }

    public function findEmployeeById(int $id): ?Employee
    {
        try {
            return $this->model->findOrFail($id);
        } catch (\Throwable $th) {
            \Log::info($th->getMessage());
            return null;
        }
    }

    public function create(array $params = []): ?Employee
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

    public function update(?int $id, array $data = []): ?Employee
    {
        if (is_null($id) || empty($data)) {
            return null;
        }

        try {
            $employee = $this->model->find($id);
            if (is_null($employee)) {
                return null;
            }

            $employee->update($data);
            return $employee;
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

        $employee = $this->findEmployeeById(
                $id
            );

        if (is_null($employee)) {
            return false;
        }

        return $employee->delete();
    }

}