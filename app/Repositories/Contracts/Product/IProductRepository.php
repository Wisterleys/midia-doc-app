<?php

namespace App\Repositories\Contracts\Product;

interface IProductRepository
{
    public function all();
    public function findById($id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete($id);
    public function search($search);
}
