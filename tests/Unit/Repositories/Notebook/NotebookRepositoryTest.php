<?php

namespace Tests\Unit\Repositories\Notebook;

use App\Models\Notebook;
use App\Repositories\Entities\Notebook\NotebookRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotebookRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected NotebookRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedTestNotebook();
        $this->repository = new NotebookRepository();
    }

    public function testNotebookCreateWithValidData()
    {
        $data = [
            'brand' => 'Dell',
            'model' => 'Inspiron 15',
            'serial_number' => 'SN-123456789',
            'processor' => 'Intel i7',
            'memory' => 16,
            'disk' => 512,
            'price' => 4500.00,
            'price_string' => 'R$ 4.500,00'
        ];

        $notebook = $this->repository->create($data);

        $this->assertInstanceOf(
            Notebook::class, 
            $notebook
        );
        $this->assertEquals(
            'Dell',
            $notebook->brand
        );
        $this->assertEquals(
            'Inspiron 15', 
            $notebook->model
        );
        $this->assertEquals(
            'SN-123456789', 
            $notebook->serial_number
        );
    }

    public function testNotebookCreateReturnsNullWhenDataIsEmpty()
    {
        $result = $this->repository->create([]);
        $this->assertNull(
            $result
        );
    }

    public function testNotebookFindByIdReturnsCorrectNotebook()
    {
        $this->testNotebookCreateWithValidData();

        $notebook = $this->repository
            ->allNotebooks(
                [
                    'search' => 'Dell'
                ]
            )
            ->first();

        $this->assertNotNull(
            $notebook
        );

        $found = $this->repository
            ->findNotebookById(
                $notebook->id
            );

        $this->assertNotNull(
            $found
        );
        $this->assertEquals(
            $notebook->id, 
            $found->id
        );
        $this->assertEquals(
            'Dell', 
            $found->brand
        );
    }

    public function testFindNotebookByIdReturnsNullWhenNotFound()
    {
        $result = $this->repository->findNotebookById(999999);
        $this->assertNull(
            $result
        );
    }

    public function testUpdateNotebookWithValidData()
    {
        $this->testNotebookCreateWithValidData();

        $notebook = $this->repository
            ->allNotebooks()
            ->first();

        $updated = $this->repository->update(
            $notebook->id, 
            [
                'brand' => 'Asus',
                'model' => 'ZenBook'
            ]
        );

        $this->assertEquals(
            'Asus', 
            $updated->brand
        );
        $this->assertEquals(
            'ZenBook', 
            $updated->model
        );
    }

    public function testUpdateNotebookWithEmptyDataReturnsNull()
    {
        $this->testNotebookCreateWithValidData();

        $notebook = $this->repository
            ->allNotebooks()
            ->first();

        $result = $this->repository->update(
            $notebook->id, 
            []
        );
        $this->assertNull(
            $result
        );
    }

    public function testUpdateNotebookWithInvalidIdReturnsNull()
    {
        $result = $this->repository->update(
            999999, 
            [
                'brand' => 'Fake',
                'model' => 'FakeBook'
            ]
        );

        $this->assertNull(
            $result
        );
    }

    public function testDeleteExistingNotebook()
    {
        $this->testNotebookCreateWithValidData();

        $notebook = $this->repository
            ->allNotebooks()
            ->first();

        $this->assertNotNull(
            $notebook
        );

        $result = $this->repository
            ->delete(
                $notebook->id
            );

        $this->assertTrue(
            $result
        );

        $found = $this->repository
            ->findNotebookById(
                $notebook->id
            );

        $this->assertNull(
            $found
        );
    }

    public function testDeleteNonExistentNotebookReturnsFalse()
    {
        $result = $this->repository->delete(999999);
        $this->assertFalse(
            $result
        );
    }

    public function testAllNotebooksReturnsBuilderInstance()
    {
        $builder = $this->repository->allNotebooks();
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Builder::class, 
            $builder
        );
    }

    public function testAllNotebooksWithSearchFilter()
    {
        $results = $this->repository->allNotebooks(
            [
                'search' => 'ASUSVB1590'
            ]
        )->get();

        $this->assertCount(1, $results);
        $this->assertEquals(
            'Asus', 
            $results->first()->brand
        );

        $results = $this->repository->allNotebooks(
            [
                'search' => 'Lenovo'
            ]
        )->get();

        $this->assertCount(
            2, 
            $results
        );
        $this->assertEquals(
            'Lenovo', 
            $results->first()->brand
        );
    }
}
