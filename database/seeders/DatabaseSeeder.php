<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);


        User::factory(9)->create();

        $this->call([
            ClientSeeder::class,
        ]);
    }
}
