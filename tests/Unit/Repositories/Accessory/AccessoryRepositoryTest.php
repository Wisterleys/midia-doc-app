<?php

namespace Tests\Unit\Repositories\Accessory;

use App\Models\Accessory;
use App\Repositories\Entities\Accessory\AccessoryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccessoryRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected AccessoryRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedAccessoriesMock();
        $this->repository = new AccessoryRepository();
    }

    public function testAccessoryCreateWithValidData()
    {
        $data = [
            'brand' => 'Dell',
            'name' => 'Mouse óptico',
            'description' => 'Mouse com fio USB'
        ];

        $accessory = $this->repository
            ->create(
                $data
            );

        $this->assertInstanceOf(
            Accessory::class, $accessory
        );
        $this->assertEquals(
            'Dell', 
            $accessory->brand
        );
        $this->assertEquals(
            'Mouse óptico', 
            $accessory->name
        );
        $this->assertEquals(
            'Mouse com fio USB', 
            $accessory->description
        );
    }

    public function testAccessoryCreateReturnsNullWhenDataIsEmpty()
    {
        $result = $this->repository->create([]);
        $this->assertNull(
            $result
        );
    }

    public function testAccessoryFindByIdReturnsCorrectAccessory()
    {
        $accessory = Accessory::factory()->create([
            'brand' => 'Logitech',
            'name' => 'Teclado Wireless'
        ]);

        $found = $this->repository
            ->findAccessoryById(
                $accessory->id
            );

        $this->assertNotNull(
            $found
        );
        $this->assertEquals(
            $accessory->id, 
            $found->id
        );
        $this->assertEquals(
            'Logitech', 
            $found->brand
        );
    }

    public function testFindAccessoryByIdReturnsNullWhenNotFound()
    {
        $result = $this->repository->findAccessoryById(999999);
        $this->assertNull(
            $result
        );
    }

    public function testUpdateAccessoryWithValidData()
    {
        $accessory = Accessory::factory()->create();

        $updated = $this->repository->update(
            $accessory->id, 
            [
                'brand' => 'Asus',
                'name' => 'Fone de ouvido'
            ]
        );

        $this->assertEquals(
          'Asus', 
          $updated->brand
        );
        $this->assertEquals(
            'Fone de ouvido', 
            $updated->name
        );
    }

    public function testUpdateAccessoryWithEmptyDataReturnsNull()
    {
        $accessory = Accessory::factory()->create();

        $result = $this->repository->update(
            $accessory->id, 
            []
        );
        $this->assertNull(
            $result
        );
    }

    public function testUpdateAccessoryWithInvalidIdReturnsNull()
    {
        $result = $this->repository->update(
            999999, 
            [
                'brand' => 'Fake',
                'name' => 'Fake accessory'
            ]
        );

        $this->assertNull(
            $result
        );
    }

    public function testDeleteExistingAccessory()
    {
        $accessory = Accessory::factory()->create();

        $this->assertNotNull(
            $accessory
        );

        $result = $this->repository
            ->delete(
                $accessory->id
            );
        $this->assertTrue(
            $result
        );

        $found = $this->repository
            ->findAccessoryById(
                $accessory->id
            );

        $this->assertNull(
            $found
        );
    }

    public function testDeleteNonExistentAccessoryReturnsFalse()
    {
        $result = $this->repository->delete(999999);
        $this->assertFalse(
            $result
        );
    }

    public function testAllAccessoriesReturnsBuilderInstance()
    {
        $builder = $this->repository->allAccessories();
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Builder::class, 
            $builder
        );
    }

    public function testAllAccessoriesWithSearchFilter()
    {
        $accessory = Accessory::factory()->create([
            'brand' => 'Lenovo Nova geração X',
            'name' => 'Mouse sem fio'
        ]);

        $results = $this->repository->allAccessories([
            'search' => 'Lenovo Nova geração X'
        ])->get();

        $this->assertCount(
            1, 
            $results
        );
        $this->assertEquals(
            'Lenovo Nova geração X', 
            $results->first()->brand
        );
    }
}
