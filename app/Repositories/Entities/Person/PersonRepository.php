<?php

namespace App\Repositories\Entities\Person;

use App\Models\Person;
use App\Repositories\Contracts\Person\IPersonRepository;

class PersonRepository implements IPersonRepository
{
    protected $entity;

    public function __construct(Person $person)
    {
        $this->entity = $person;
    }

    public function findById(int $id)
    {
        return $this->entity->find($id);
    }

    public function create(array $data)
    {
        return $this->entity->create($data);
    }

    public function update(int $id, array $data)
    {
        $person = $this->findById($id);
        
        if (!$person) {
            return null;
        }

        $person->update($data);
        return $person;
    }

    public function delete(int $id)
    {
        $person = $this->findById($id);
        
        if (!$person) {
            return false;
        }

        return $person->delete();
    }

    public function findByUserId(int $userId)
    {
        return $this->entity->where('user_id', $userId)->first();
    }

    public function findByCpf(string $cpf)
    {
        return $this->entity->where('cpf', $cpf)->first();
    }
}