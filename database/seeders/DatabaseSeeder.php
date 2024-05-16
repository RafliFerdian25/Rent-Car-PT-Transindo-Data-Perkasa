<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'email' => 'admin@rentcar.com',
            'email_verified_at' => now(),
            'password' => bcrypt('Secret123'),
            'role' => 'admin',
            'name' => 'admin',
            'address' => 'Jl. Admin No. 1',
            'phone' => '081234567890',
            'driving_license' => '1234567890',
        ]);

        $this->call([
            BrandSeeder::class,
            CarTypeSeeder::class,
            CarSeeder::class,
        ]);
    }
}
