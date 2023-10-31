<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testLoginWithValidCredentials()
    {
        User::factory()->create([
            'name' => 'ivan',
            'email' => 'user@example.com',
            'login' => 'user1',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/api/v1/login', [
            'login' => 'user@example.com',
            'password' => 'password123',
        ]);
        $response->assertJsonStructure(['status',
            'message',
            'data' => [
                'token',
            ]]);
    }

    public function testLoginWithInvalidCredentials()
    {
        $response = $this->post('/api/v1/login', [
            'login' => 'user2@313m.ru',
            'password' => 'iweord',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'wrong input data',
            ]);
    }
}
