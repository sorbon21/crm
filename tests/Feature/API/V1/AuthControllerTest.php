<?php

namespace Tests\Feature\API\V1;

use App\Enums\RBAC;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class AuthControllerTest extends TestCase
{
    use RefreshDatabase;
    use UserTrait;

    public function testLoginWithValidCredentials()
    {
        $this->createUsers();

        $response = $this->post('/api/v1/login', [
            'login' => 'user1',
            'password' => 'password',
        ]);
        $response->assertJsonStructure(['status',
            'message',
            'data' => [
                'token',
            ]]);
        $response = $this->post('/api/v1/login', [
            'login' => 'user2',
            'password' => 'password',
        ]);
        $response->assertJsonStructure(['status',
            'message',
            'data' => [
                'token',
            ]]);
        $response = $this->post('/api/v1/login', [
            'login' => 'user3',
            'password' => 'password',
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
