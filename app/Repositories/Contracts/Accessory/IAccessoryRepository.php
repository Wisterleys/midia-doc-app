<?php

namespace App\Repositories\Contracts\Accessory;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Accessory;

interface IAccessoryRepository
{
    public function allAccessories(array $params = []): Builder;
    public function findAccessoryById(int $id): ?Accessory;
    public function create(array $params = []): ?Accessory;
    public function update(?int $id, array $data = []): ?Accessory;
    public function delete($id): bool;
}
