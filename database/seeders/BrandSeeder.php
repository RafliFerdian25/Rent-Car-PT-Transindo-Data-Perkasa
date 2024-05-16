<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Toyota',
                'country' => 'Japan',
            ],
            [
                'name' => 'Honda',
                'country' => 'Japan',
            ],
            [
                'name' => 'Suzuki',
                'country' => 'Japan',
            ],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
