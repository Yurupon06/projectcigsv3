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
        // User::factory(10)->create();

        User::factory()->customer()->create([
            'name' => 'Customer',
            'email' => 'customer@gmail.com',
        ]);
        User::factory()->admin()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
        ]);
        User::factory()->cashier()->create([
            'name' => 'Cashier',
            'email' => 'cashier@gmail.com',
        ]);
    }
}
