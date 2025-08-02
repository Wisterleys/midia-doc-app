<?php

namespace App\Repositories\Contracts\Employee;

use Illuminate\Database\Eloquent\Builder;

interface IEmployeeRepository
{
    public function allUserEmployees(array $params = []): Builder;
    public function findEmployeeById(int $id);
    public function create(array $params = []);
    public function update(int $id);
    public function delete($id);
}
