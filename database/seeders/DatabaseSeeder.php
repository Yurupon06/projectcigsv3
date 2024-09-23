<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(5)->create();

        $user = User::factory()->customer()->create([
            'name' => 'Customer',
            'email' => 'customer@gmail.com',
            'phone' => '081293962019',
        ]);
        $admin = User::factory()->admin()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'phone' => '1234567890',
        ]);
        $cashier = User::factory()->cashier()->create([
            'name' => 'Cashier',
            'email' => 'cashier@gmail.com',
            'phone' => '0987654321',
        ]);
        Customer::create([
            'user_id' => $user->id,
            'phone' => $user->phone,
        ]);
        Customer::create([
            'user_id' => $admin->id,
            'phone' => $admin->phone,
        ]);
        Customer::create([
            'user_id' => $cashier->id,
            'phone' => $cashier->phone,
        ]);
    }
}
