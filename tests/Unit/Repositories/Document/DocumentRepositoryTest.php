<?php

namespace Tests\Unit\Repositories\Document;

use App\Models\Document;
use App\Models\Employee;
use App\Models\Notebook;
use App\Models\Accessory;
use App\Models\User;
use App\Repositories\Entities\Document\DocumentRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DocumentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected DocumentRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedTestUser();
        $this->seedTestNotebook();
        $this->seedTestAccessory();
        $this->repository = new DocumentRepository();
    }

    public function testDocumentCreateWithValidData()
    {
        $user = User::first();
        $employee = Employee::factory()
            ->create(
                ['user_id' => $user->id]
            );
        $notebook = $this->allNotebooks()->first();

        $data = [
            'employee_id' => $employee->id,
            'notebook_id' => $notebook->id,
            'local' => 'Departamento de TI',
            'date' => now(),
            'user_id' => $user->id,
        ];

        $document = $this->repository->create($data);

        $this->assertInstanceOf(
            Document::class, 
            $document
        );
        $this->assertEquals(
            'Departamento de TI', 
            $document->local
        );
        $this->assertEquals(
            $employee->id, 
            $document->employee_id
        );
        $this->assertEquals(
            $notebook->id, 
            $document->notebook_id
        );
    }

    public function testDocumentCreateReturnsNullWhenDataIsEmpty()
    {
        $result = $this->repository->create([]);
        $this->assertNull($result);
    }

    public function testDocumentCreateReturnsNullWhenUserIdMissing()
    {
        $data = [
            'employee_id' => 1,
            'notebook_id' => 1,
            'local' => 'TI',
            'date' => now(),
        ];

        $result = $this->repository
            ->create(
                $data
            );
        $this->assertNull(
            $result
        );
    }

    public function testFindDocumentByIdReturnsCorrectDocument()
    {
        $this->testDocumentCreateWithValidData();

        $document = Document::first();
        $found = $this->repository
            ->findDocumentById(
                $document->id
            );

        $this->assertEquals(
            $document->id, 
            $found->id
        );
    }

    public function testDeleteExistingDocument()
    {
        $this->testDocumentCreateWithValidData();

        $document = Document::first();
        $result = $this->repository
            ->delete(
                $document->id
            );

        $this->assertTrue(
            $result
        );
        $this->assertDatabaseMissing(
            'documents', 
            ['id' => $document->id]
        );
    }

    public function testDeleteNonExistentDocumentReturnsFalse()
    {
        $result = $this->repository->delete(999999);
        $this->assertFalse(
            $result
        );
    }

    public function testAllUserDocumentsReturnsBuilderInstance()
    {
        $user = User::first();
        $builder = $this->repository
            ->allUserDocuments(
                ['user_id' => $user->id]
            );
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Builder::class, 
            $builder
        );
    }

    public function testAllUserDocumentsWithoutUserIdReturnsEmptyBuilder()
    {
        $result = $this->repository->allUserDocuments();
        $this->assertNull(
            $result
        );
    }

    public function testAllUserDocumentsWithSearchFilter()
    {
        $employee = Employee::factory()
            ->for(User::factory()->create(['name' => 'John Doe']))
            ->create([
                'name' => 'Diego Osinski',
                'cpf' => '818.232.483-06',
                'role' => 'analista'
            ]);

        $notebook = Notebook::factory()->create([
            'brand' => 'Dell',
            'model' => 'XPS 15',
            'serial_number' => 'SN123456'
        ]);

        $documents = Document::factory()
            ->count(3)
            ->for($employee)
            ->for($notebook)
            ->sequence(
                ['local' => 'Sala 101', 'date' => '2024-09-30'],
                ['local' => 'Sala 202', 'date' => '2025-01-11'],
                ['local' => 'Remoto', 'date' => '2024-12-28']
            )
            ->create();

        $results = $this->repository->allUserDocuments([
            'user_id' => $employee->user_id,
            'search' => 'Sala 101'
        ])->get();

        $this->assertCount(
            1, 
            $results
        );
        $this->assertEquals(
            'Sala 101', 
            $results->first()->local
        );

        $results = $this->repository->allUserDocuments([
            'user_id' => $employee->user_id,
            'search' => '2025-01-11 00:00:00'
        ])->get();

        $this->assertCount(
            1, 
            $results
        );
        $this->assertEquals(
            '2025-01-11 00:00:00', 
            $results->first()->date
        );

        $results = $this->repository->allUserDocuments([
            'user_id' => $employee->user_id,
            'search' => 'Diego'
        ])->get();

        $this->assertCount(3, $results);

        $results = $this->repository->allUserDocuments([
            'user_id' => $employee->user_id,
            'search' => '818.232.483-06'
        ])->get();

        $this->assertCount(
            3, 
            $results
        );

        $results = $this->repository->allUserDocuments([
            'user_id' => $employee->user_id,
            'search' => 'analista'
        ])->get();

        $this->assertCount(
            3, 
            $results
        );

        $results = $this->repository->allUserDocuments([
            'user_id' => $employee->user_id,
            'search' => 'Dell'
        ])->get();

        $this->assertCount(
            3, 
            $results
        );

        $results = $this->repository->allUserDocuments([
            'user_id' => $employee->user_id,
            'search' => 'XPS'
        ])->get();

        $this->assertCount(
            3, 
            $results
        );

        $results = $this->repository->allUserDocuments([
            'user_id' => $employee->user_id,
            'search' => 'SN123456'
        ])->get();

        $this->assertCount(
            3, 
            $results
        );

        $results = $this->repository->allUserDocuments([
            'user_id' => $employee->user_id,
            'search' => ''
        ])->get();

        $this->assertCount(3, $results);
    }

    public function testDocumentSyncAccessoriesOnCreate()
    {
        $user = User::first();
        $employee = Employee::factory()->create(['user_id' => $user->id]);
        $notebook = Notebook::factory()->create();

        $accessories = $this->allAccessories()->slice(0, 3);
        
        $data = [
            'employee_id' => $employee->id,
            'notebook_id' => $notebook->id,
            'local' => 'Sala de Testes',
            'date' => now(),
            'user_id' => $user->id,
            'accessories_ids' => $accessories->pluck('id')->toArray()
        ];

        
        $document = $this->repository
            ->create(
                $data
            );

        $this->assertCount(
            3, 
            $notebook->fresh()->accessories
        );
        $this->assertEquals(
            $accessories->pluck('id')->sort()->values()->toArray(),
            $notebook->fresh()->accessories->pluck('id')->sort()->values()->toArray()
        );
    }

    public function testDocumentSyncAccessoriesOnUpdate()
    {
        $user = User::first();
        $employee = Employee::factory()->create(['user_id' => $user->id]);
        $notebook = Notebook::factory()->create();
        
        $initial_accessories = Accessory::factory()->count(2)->create();
        
        $data = [
            'employee_id' => $employee->id,
            'notebook_id' => $notebook->id,
            'user_id' => $user->id,
            'local' => 'Sala de Testes',
            'date' => now(),
            'accessories_ids' => $initial_accessories->pluck('id')->toArray()
        ];

        $document = $this->repository
            ->create(
                $data
            );

        $this->assertCount(
            2, 
            $notebook->fresh()->accessories
        );

        $new_accessories = Accessory::factory()->count(3)->create();

        $updated_data = [
            'accessories_ids' => $new_accessories->pluck('id')->toArray()
        ];

        $this->repository->update(
            $document->id, 
            $updated_data
        );

        $this->assertCount(
            3, 
            $notebook->fresh()->accessories
        );
        $this->assertEquals(
            $new_accessories->pluck('id')->sort()->values()->toArray(),
            $notebook->fresh()->accessories->pluck('id')->sort()->values()->toArray()
        );
    }

    public function testDocumentRemovesUnusedAccessoriesOnUpdate()
    {
        $user = User::first();
        $employee = Employee::factory()->create(['user_id' => $user->id]);
        $notebook = Notebook::factory()->create();
        
        
        $accessories = Accessory::factory()->count(4)->create();
        
        $data = [
            'employee_id' => $employee->id,
            'notebook_id' => $notebook->id,
            'user_id' => $user->id,
            'local' => 'Sala de Testes',
            'date' => now(),
            'accessories_ids' => $accessories->pluck('id')->toArray()
        ];

        $document = $this->repository
            ->create(
                $data
            );

        $this->assertCount(
            4, 
            $notebook->fresh()->accessories
        );

        $updated_data = [
            'accessories_ids' => $accessories->take(2)->pluck('id')->toArray()
        ];

        $this->repository->update(
            $document->id, 
            $updated_data
        );

        $this->assertCount(
            2, 
            $notebook->fresh()->accessories
        );
        $this->assertEquals(
            $accessories->take(2)->pluck('id')->sort()->values()->toArray(),
            $notebook->fresh()->accessories->pluck('id')->sort()->values()->toArray()
        );
    }

    public function testDocumentDoesNotSyncAccessoriesWhenIdsNotProvided()
    {
        $user = User::first();
        $employee = Employee::factory()->create(['user_id' => $user->id]);
        $notebook = Notebook::factory()->create();
        
        $data = [
            'employee_id' => $employee->id,
            'notebook_id' => $notebook->id,
            'local' => 'Sala de Testes',
            'date' => now(),
            'user_id' => $user->id
        ];

        $document = $this->repository
            ->create(
                $data
            );

        $this->assertCount(
            0, 
            $notebook->fresh()->accessories
        );
    }

    public function testDocumentDoesNotSyncAccessoriesWhenNotebookIdNotProvided()
    {
        $user = User::first();
        $employee = Employee::factory()->create(['user_id' => $user->id]);
        
        $accessories = Accessory::factory()->count(2)->create();
        
        $data = [
            'employee_id' => $employee->id,
            'local' => 'Sala de Testes',
            'date' => now(),
            'user_id' => $user->id,
            'accessories_ids' => $accessories->pluck('id')->toArray()
        ];

        $document = $this->repository->create($data);

        $this->assertNull(
            $document
        );
    }

    public function testUserCanOnlySeeTheirOwnDocuments()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        
        $employee1 = Employee::factory()->create(['user_id' => $user1->id]);
        $employee2 = Employee::factory()->create(['user_id' => $user2->id]);
        
        $notebook = Notebook::factory()->create();
        
        Document::factory()
            ->count(3)
            ->create([
                'employee_id' => $employee1->id,
                'notebook_id' => $notebook->id
            ]);
        
        Document::factory()
            ->count(2)
            ->create([
                'employee_id' => $employee2->id,
                'notebook_id' => $notebook->id
            ]);
        
        $employee1_documents = $this->repository
            ->allUserDocuments(['user_id' => $user1->id])
            ->get();
        
        $this->assertCount(
            3, 
            $employee1_documents
        );
        $this->assertTrue(
                $employee1_documents->every(function ($document) use ($employee1) {
                return $document->employee_id === $employee1->id;
            })
        );
        
        $employee2_documents = $this->repository
            ->allUserDocuments(
                ['user_id' => $user2->id]
            )
            ->get();
        
        $this->assertCount(
            2, 
            $employee2_documents
        );
        $this->assertTrue(
                $employee2_documents->every(function ($document) use ($employee2) {
                return $document->employee_id === $employee2->id;
            })
        );
        
        $all_documents = $this->allDocuments();
        $this->assertCount(
            5, 
            $all_documents
        );
        
        $employee1_sees_employee2_documents = $employee1_documents->contains(function ($document) use ($employee2) {
            return $document->employee_id === $employee2->id;
        });
        $this->assertFalse(
            $employee1_sees_employee2_documents
        );
        
        $employee2_sees_employee1_documents = $employee2_documents->contains(function ($document) use ($employee1) {
            return $document->employee_id === $employee1->id;
        });
        $this->assertFalse(
            $employee2_sees_employee1_documents
        );
    }
}
