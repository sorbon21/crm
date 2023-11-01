<?php

namespace Tests\Feature\API\V1;

use App\Enums\RBAC;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class ClientControllerTest extends TestCase
{
    use RefreshDatabase;
    use UserTrait;

    public function testIndex()
    {
        $this->createUsers();
        $token = $this->getToken('user2', 'password');
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];
        $response = $this->withHeaders($headers)->get('/api/v1/client');
        $response->assertJsonStructure(['status',
            'message',
            'data' => [
                'data',
            ]]);
    }


}
