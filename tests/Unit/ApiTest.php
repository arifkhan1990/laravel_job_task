<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_api_endpoints_return_expected_responses()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();
        $response = $this->get('/api/user');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success' => [
                    "message"
                ],
            ]);
        // Add more tests for other API endpoints
    }

    public function test_successful_user_registration()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            "success" => [
                "message",
            ]
        ]);
    }

    /** @test */
    public function test_invalid_login_credentials()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'invalidpassword',
        ]);
        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'User not Found!',
        ]);
    }

    /** @test */
    public function test_accessing_protected_resource_without_authentication()
    {
        $response = $this->getJson('/api/user');

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthorized.',
        ]);
    }

    /** @test */
    public function test_validating_required_fields_on_registration()
    {
        // Test user registration with missing required fields
        $response = $this->postJson('/api/register', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'email', 'password']);
    }
}
