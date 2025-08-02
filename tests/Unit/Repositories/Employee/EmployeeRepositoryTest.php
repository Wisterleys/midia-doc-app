<?php

namespace Tests\Unit\Repositories\Employee;

use App\Models\Employee;
use App\Repositories\Entities\Employee\EmployeeRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected EmployeeRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedTestUser();
        $this->repository = new EmployeeRepository();
    }

    public function testEmployeeCreateWithValidData()
    {
        $users = $this->allUsers();

        $data = [
            'user_id' => $users->first()->id,
            'name' => 'João da Silva',
            'cpf' => '123.456.789-00',
            'role' => 'analista'
        ];

        $employee = $this->repository->create($data);

        $this->assertEquals(
            $users->first()->id, 
            $employee->user_id
        );
        $this->assertEquals(
            'João da Silva', 
            $employee->name
        );
        $this->assertEquals(
            '123.456.789-00', 
            $employee->cpf
        );
        $this->assertEquals(
            'analista', 
            $employee->role
        );
    }

    public function testEmployeeCreateReturnsNullWhenDataIsEmpty()
    {
        $result = $this->repository
            ->create(
                []
            );

        $this->assertNull(
            $result
        );
    }

    public function testEmployeeCreateReturnsNullWhenUserIdIsMissing()
    {
        $result = $this->repository->create([
            'name' => 'Sem usuário',
            'cpf' => '000.000.000-00',
            'role' => 'estagiario'
        ]);

        $this->assertNull($result);
    }

    public function testEmployeeFindEmployeeByIdReturnsCorrectEmployee()
    {
        $this->testEmployeeCreateWithValidData();

        $employee = $this->allEmployees()->first();

        $found = $this->repository
            ->findEmployeeById(
                $employee->id
            );

        $this->assertEquals(
            $employee->id, 
            $found->id
        );
    }

    public function testEmployeeAllUserEmployeesReturnsBuilder()
    {
        $builder = $this->repository->allUserEmployees();

        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Builder::class, 
            $builder
        );
    }

    public function testEmployeeDeleteExistingEmployee()
    {
        $this->testEmployeeCreateWithValidData();

        $employee = $this->allEmployees()->first();

        $this->assertNotNull(
            $employee
        );

        $result = $this->repository
            ->delete(
                $employee->id
            );

        $this->assertTrue($result);
        
        $found = $this->repository
            ->findEmployeeById(
                $employee->id
            );

        $this->assertNull(
            $found
        );
    }

    public function testEmployeeDeleteNonExistentEmployeeReturnsNull()
    {
        $result = $this->repository->delete(999999);

        $this->assertFalse(
            $result
        );
    }

    public function testEmployeeUpdateReturnsNullWhenIdIsNull()
    {
        $result = $this->repository->update(
            null
        );

        $this->assertNull(
            $result
        );
    }

    public function testEmployeeUpdateEmployeeWithValidData()
    {
        $this->testEmployeeCreateWithValidData();

        $employee = $this->allEmployees()->first();

        $updated = $this->repository->update($employee->id, [
            'name' => 'Novo Nome',
            'role' => 'analista'
        ]);

        $this->assertEquals(
            'Novo Nome', $updated->name
        );
        $this->assertEquals(
            'analista', $updated->role
        );

        $employee_updated = $this->repository
            ->findEmployeeById(
                $employee->id
            );

        $this->assertEquals(
            'Novo Nome', $employee_updated->name
        );
        $this->assertEquals(
            'analista', $employee_updated->role
        );
    }

    public function testEmployeeUpdateEmployeeWithEmptyDataReturnsNull()
    {
        $this->testEmployeeCreateWithValidData();

        $employee = $this->allEmployees()->first();

        $result = $this->repository->update($employee->id, []);
        $this->assertNull(
            $result
        );
    }

    public function testEmployeeUpdateEmployeeWithInvalidIdReturnsNull()
    {
        $result = $this->repository->update(999999, [
            'name' => 'Inexistente',
            'role' => 'admin'
        ]);

        $this->assertNull(
            $result
        );
    }

}
