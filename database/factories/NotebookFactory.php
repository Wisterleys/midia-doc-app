<?php

namespace Database\Factories;

use App\Models\Notebook;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotebookFactory extends Factory
{
    protected $model = Notebook::class;

    public function definition(): array
    {
        $brands = ['Dell', 'HP', 'Lenovo', 'Apple', 'Asus', 'Acer'];
        $processors = ['Intel Core i5', 'Intel Core i7', 'AMD Ryzen 5', 'AMD Ryzen 7'];
        $disks = [256, 512, 1024]; // em GB
        $memories = [8, 16, 32]; // em GB

        $brand = $this->faker->randomElement($brands);
        $model = $this->faker->bothify('?#?##?');
        $price = $this->faker->numberBetween(3000, 15000);

        return [
            'brand' => $brand,
            'model' => $model,
            'serial_number' => strtoupper($this->faker->bothify('SN#########')),
            'processor' => $this->faker->randomElement($processors),
            'memory' => $this->faker->randomElement($memories),
            'disk' => $this->faker->randomElement($disks),
            'price' => $price,
            'price_string' => 'R$ ' . number_format($price, 2, ',', '.'),
        ];
    }

    // Métodos adicionais para estados específicos
    public function premium(): self
    {
        return $this->state([
            'memory' => 32,
            'disk' => 1024,
            'processor' => 'Intel Core i9',
            'price' => 12000,
        ]);
    }

    public function basic(): self
    {
        return $this->state([
            'memory' => 8,
            'disk' => 256,
            'processor' => 'Intel Core i3',
            'price' => 3000,
        ]);
    }
}