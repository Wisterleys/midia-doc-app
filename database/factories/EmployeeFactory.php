<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        $user = User::factory()->create();

        return [
            'user_id' => $user->id,
            'name' => $this->faker->name(),
            'cpf' => $this->faker->numerify('###.###.###-##'),
            'role' => $this->faker->randomElement(['analista', 'gerente', 'estagiario', 'admin']),
            'ativo' => 1
        ];
    }
}
