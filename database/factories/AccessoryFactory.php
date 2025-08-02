<?php

namespace Database\Factories;

use App\Models\Accessory;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccessoryFactory extends Factory
{
    protected $model = Accessory::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->text(60),
            'brand' => $this->faker->randomElement(['Dell', 'HP', 'Lenovo', 'Asus', 'Acer']),
        ];
    }
}
