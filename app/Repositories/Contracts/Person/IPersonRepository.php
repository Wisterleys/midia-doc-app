<?php

namespace App\Repositories\Contracts\Person;

interface IPersonRepository
{
    public function findById(int $id);
    
    public function create(array $data);
    
    public function update(int $id, array $data);
    
    public function delete(int $id);
    
    public function findByUserId(int $userId);
    
    public function findByCpf(string $cpf);
}