<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $password = 'password';

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => 'john@example.com',
            'password' => bcrypt($this->password),
        ]);
    }

    /** @test */
    public function user_can_login_with_correct_credentials()
    {
        $response = $this->postJson('/api/login', [
            'email' => $this->user->email,
            'password' => $this->password,
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'token',
            'user' => ['id', 'name', 'email'],
        ]);
    }

    /** @test */
    public function user_cannot_login_with_wrong_password()
    {
        $response = $this->postJson('/api/login', [
            'email' => $this->user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(422) ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function authenticated_user_can_access_user_endpoint()
    {
        $token = $this->user->createToken('api-token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->getJson('/api/user');

        $response->assertStatus(200)->assertJson([
            'id' => $this->user->id,
            'email' => $this->user->email,
        ]);
    }

    /** @test */
    public function user_can_logout_and_token_is_revoked()
    {
        $token = $this->user->createToken('api-token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->postJson('/api/logout');

        $response->assertStatus(200)->assertJson([
            'message' => 'Logged out successfully',
        ]);

        $this->assertCount(0, $this->user->tokens); 
    }
}
