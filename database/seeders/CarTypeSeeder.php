<?php

namespace Database\Seeders;

use App\Models\CarType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'Sedan',
            ],
            [
                'name' => 'SUV',
            ],
            [
                'name' => 'MPV',
            ],
            [
                'name' => 'Hatchback',
            ],
            [
                'name' => 'Coupe',
            ],
            [
                'name' => 'Convertible',
            ],
            [
                'name' => 'Pickup',
            ],
            [
                'name' => 'Minivan',
            ],
            [
                'name' => 'Van',
            ],
            [
                'name' => 'Truck',
            ],
        ];

        foreach ($types as $type) {
            CarType::create($type);
        }
    }
}
