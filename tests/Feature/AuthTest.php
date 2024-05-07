<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    public function test_user_registration()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john271@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(201);
    }

    public function test_user_login()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success' => [
                    'status',
                    'message',
                    'code',
                    'data' => [
                        'user' => [
                            'id',
                            'name',
                            'email',
                            'email_verified_at',
                            'created_at',
                            'updated_at',
                        ],
                        'authorisation' => [
                            'token',
                            'type',
                        ],
                    ],
                ],
            ]);

        $this->assertAuthenticated();
        $token = $response->json('success.data.authorisation.token');
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->get('/api/user');
        $response->assertStatus(200);
        // $response->assertJson(['id' => 1]); // Assuming user ID is 1

        // Test user logout
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->postJson('/api/logout');
        $response->assertStatus(200);
    }


    public function test_fetch_user_details()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success' => [
                    'status',
                    'message',
                    'code',
                    'data' => [
                        'authorisation' => [
                            'token',
                            'type',
                        ],
                    ],
                ],
            ]);

        $this->assertAuthenticated();
    }
}
