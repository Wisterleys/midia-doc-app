<?php

namespace App\Repositories\Entities\Accessory;

use App\Models\Accessory;
use App\Repositories\Contracts\Accessory\IAccessoryRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

class AccessoryRepository implements IAccessoryRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Accessory();
    }

    public function allAccessories(array $params = []): Builder
    {
        $query = $this->model::query()
            ->select([
                'id', 'name', 'description', 'brand'
            ]);

        if (isset($params['search'])) {
            $search = $params['search'];

            $query->where(function (Builder $q) use ($search) {
                $q->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('name');
    }

    public function findAccessoryById(int $id): ?Accessory
    {
        try {
            return $this->model->findOrFail($id);
        } catch (\Throwable $th) {
            \Log::info($th->getMessage());
            return null;
        }
    }

    public function create(array $params = []): ?Accessory
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

    public function update(?int $id, array $data = []): ?Accessory
    {
        if (is_null($id) || empty($data)) {
            return null;
        }

        try {
            $accessory = $this->model->find($id);
            if (is_null($accessory)) {
                return null;
            }

            $accessory->update($data);
            return $accessory;
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

        $accessory = $this->findAccessoryById(
                $id
            );

        if (is_null($accessory)) {
            return false;
        }

        return $accessory->delete();
    }

}