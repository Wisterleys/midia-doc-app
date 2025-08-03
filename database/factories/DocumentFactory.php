<?php

namespace Database\Factories;

use App\Models\Document;
use App\Models\Employee;
use App\Models\Notebook;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    protected $model = Document::class;

    public function definition(): array
    {
        return [
            'employee_id' => Employee::factory(),
            'notebook_id' => Notebook::factory(),
            'local' => $this->faker->randomElement(['Sala 101', 'Sala 202', 'Remoto', 'Filial SP', 'Filial RJ']),
            'date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
        ];
    }
}