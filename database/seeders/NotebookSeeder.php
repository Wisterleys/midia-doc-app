<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notebook;
use Illuminate\Support\Str;

class NotebookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notebooks = [
            [
                'brand' => 'Dell',
                'model' => 'Inspiron 15',
                'serial_number' => 'DELL123456',
                'processor' => 'Intel Core i5',
                'memory' => 8,
                'disk' => 512,
                'price' => 3899.90,
                'price_string' => 'R$ 3.899,90',
            ],
            [
                'brand' => 'HP',
                'model' => 'Pavilion x360',
                'serial_number' => 'HPX3607890',
                'processor' => 'Intel Core i7',
                'memory' => 16,
                'disk' => 1024,
                'price' => 5699.00,
                'price_string' => 'R$ 5.699,00',
            ],
            [
                'brand' => 'Lenovo',
                'model' => 'IdeaPad 3',
                'serial_number' => 'LEN123ABC',
                'processor' => 'Ryzen 5',
                'memory' => 8,
                'disk' => 256,
                'price' => 3149.50,
                'price_string' => 'R$ 3.149,50',
            ],
            [
                'brand' => 'Apple',
                'model' => 'MacBook Air M1',
                'serial_number' => 'MACM1A2021',
                'processor' => 'Apple M1',
                'memory' => 8,
                'disk' => 256,
                'price' => 8999.99,
                'price_string' => 'R$ 8.999,99',
            ],
            [
                'brand' => 'Acer',
                'model' => 'Aspire 5',
                'serial_number' => 'ACER9821DF',
                'processor' => 'Intel Core i3',
                'memory' => 4,
                'disk' => 128,
                'price' => 2399.00,
                'price_string' => 'R$ 2.399,00',
            ],
            [
                'brand' => 'Asus',
                'model' => 'VivoBook 15',
                'serial_number' => 'ASUSVB1590',
                'processor' => 'Ryzen 7',
                'memory' => 16,
                'disk' => 512,
                'price' => 4690.75,
                'price_string' => 'R$ 4.690,75',
            ],
            [
                'brand' => 'Samsung',
                'model' => 'Book S',
                'serial_number' => 'SAMS654321',
                'processor' => 'Intel Core i5',
                'memory' => 8,
                'disk' => 256,
                'price' => 4199.00,
                'price_string' => 'R$ 4.199,00',
            ],
            [
                'brand' => 'Lenovo',
                'model' => 'ThinkPad E14',
                'serial_number' => 'THINKLEN001',
                'processor' => 'Intel Core i7',
                'memory' => 16,
                'disk' => 512,
                'price' => 6090.90,
                'price_string' => 'R$ 6.090,90',
            ],
            [
                'brand' => 'HP',
                'model' => 'EliteBook 840',
                'serial_number' => 'ELITEHP2022',
                'processor' => 'Intel Core i5',
                'memory' => 8,
                'disk' => 256,
                'price' => 4790.00,
                'price_string' => 'R$ 4.790,00',
            ],
            [
                'brand' => 'Dell',
                'model' => 'Latitude 3420',
                'serial_number' => 'LAT3420DELL',
                'processor' => 'Intel Core i3',
                'memory' => 4,
                'disk' => 256,
                'price' => 2999.00,
                'price_string' => 'R$ 2.999,00',
            ],
        ];

        foreach ($notebooks as $data) {
            Notebook::firstOrCreate(
                ['serial_number' => $data['serial_number']],
                $data
            );
        }
    }
}
