<?php

namespace App\Repositories\Contracts\Employee;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Employee;

interface IEmployeeRepository
{
    public function allUserEmployees(array $params = []): Builder;
    public function findEmployeeById(int $id): ?Employee;
    public function create(array $params = []): ?Employee;
    public function update(?int $id, array $data = []): ?Employee;
    public function delete($id): bool;
}
