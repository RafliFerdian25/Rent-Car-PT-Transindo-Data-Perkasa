<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cars = [
            [
                'name' => 'Corolla',
                'brand_id' => 1,
                'car_type_id' => 1,
                'license_plate' => 'H 1234 ABC',
                'rental_rate' => 200000,
            ],
            [
                'name' => 'Civic',
                'brand_id' => 2,
                'car_type_id' => 1,
                'license_plate' => 'H 5678 DEF',
                'rental_rate' => 250000,
            ],
            [
                'name' => 'Ertiga',
                'brand_id' => 1,
                'car_type_id' => 3,
                'license_plate' => 'H 9101 GHI',
                'rental_rate' => 300000,
            ],
            [
                'name' => 'Innova',
                'brand_id' => 1,
                'car_type_id' => 3,
                'license_plate' => 'H 1121 JKL',
                'rental_rate' => 350000,
            ],
            [
                'name' => 'Jazz',
                'brand_id' => 2,
                'car_type_id' => 4,
                'license_plate' => 'H 3141 MNO',
                'rental_rate' => 400000,
            ],
            [
                'name' => 'HR-V',
                'brand_id' => 2,
                'car_type_id' => 2,
                'license_plate' => 'H 5161 PQR',
                'rental_rate' => 450000,
            ],
            [
                'name' => 'Rush',
                'brand_id' => 1,
                'car_type_id' => 2,
                'license_plate' => 'H 7181 STU',
                'rental_rate' => 500000,
            ],
            [
                'name' => 'Fortuner',
                'brand_id' => 1,
                'car_type_id' => 2,
                'license_plate' => 'H 9201 VWX',
                'rental_rate' => 550000,
            ],
            [
                'name' => 'Alphard',
                'brand_id' => 1,
                'car_type_id' => 9,
                'license_plate' => 'H 1221 YZA',
                'rental_rate' => 600000,
            ]
        ];

        foreach ($cars as $car) {
            Car::create($car);
        }
    }
}
