<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        return $user;
    }

    public function test_can_list_clients()
    {
        $this->authenticate();

        $this->seed(\Database\Seeders\ClientSeeder::class);

        $response = $this->getJson('/api/v1/clients');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [['id', 'first_name', 'last_name', 'email', 'phone_number']]
            ]);
    }

    public function test_can_create_client()
    {
        $user = $this->authenticate();

        $payload = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone_number' => '0812345678',
        ];

        $response = $this->postJson('/api/v1/clients', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(['email' => 'john@example.com']);

        $this->assertDatabaseHas('clients', [
            'email' => 'john@example.com',
            'created_by' => $user->id,
        ]);
    }

    public function test_can_show_client()
    {
        $this->authenticate();

        $this->seed(\Database\Seeders\ClientSeeder::class);
        $client = Client::first();

        $response = $this->getJson("/api/v1/clients/{$client->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['email' => $client->email]);
    }


    public function test_can_soft_delete_client()
    {
        $this->authenticate();


        $this->seed(\Database\Seeders\ClientSeeder::class);

        $client = Client::latest()->first();

        $response = $this->deleteJson("/api/v1/clients/{$client->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Client deleted successfully.']);

        $this->assertSoftDeleted('clients', ['id' => $client->id]);
    }
}
