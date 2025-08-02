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
            'employees.id', 'employees.employee_id', 'employees.notebook_id', 'employees.local', 'employees.date',
            'employees.name as employee_name', 'employees.cpf as employee_cpf', 'employees.role as employee_role',
            'notebooks.brand as notebook_brand', 'notebooks.model as notebook_model', 'notebooks.serial_number as notebook_serial_number'
        ]);

        if (!isset($params['user_id'])) {
            return new Builder();
        }

        $query->whereHas('employee.user', function (Builder $q) use ($params) {
                $q->where('id', $params['user_id']);
        });

        $query->join('employees', 'employees.employee_id', '=', 'employees.id')
              ->join('notebooks', 'employees.notebook_id', '=', 'notebooks.id');
        
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

        $query->orderBy('employees.date', 'desc');
        $query->orderBy('employees.id', 'desc');

        return $query;
    }

    public function findEmployeeById(int $id)
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

        $employee = $this->find($id);

        if (is_null($employee)) {
            return null;
        }

        $employee->update($data);
        return $employee;
    }

    public function delete($id)
    {
        if (is_null($id)) {
            return null;
        }

        $employee = $this->find($id);

        if (is_null($employee)) {
            return null;
        }

        return $employee->delete();
    }

}