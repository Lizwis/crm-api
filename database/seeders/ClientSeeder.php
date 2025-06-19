<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
  
        $users = User::all();

        // Create 10 clients and assign random user as `created_by`
        foreach (range(1, 10) as $i) {
            Client::create([
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'email' => fake()->unique()->safeEmail(),
                'phone_number' => fake()->phoneNumber(),
                'created_by' => $users->random()->id,
            ]);
        }
    }
}
