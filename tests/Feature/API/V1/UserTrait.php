<?php

namespace Tests\Feature\API\V1;

use App\Enums\RBAC;
use App\Models\Role;
use App\Models\User;

trait UserTrait
{
    public function createUsers(): void
    {
        $params = [
            'name' => 'user1',
            'email' => 'user1@mail.ru',
            'login' => 'user1',
            'password' => bcrypt('password'),
        ];
        $this->createUser(RBAC::Admin, $params);
        $params = [
            'name' => 'user2',
            'email' => 'user2@mail.ru',
            'login' => 'user2',
            'password' => bcrypt('password'),
        ];
        $this->createUser(RBAC::Operator, $params);
        $params = [
            'name' => 'user3',
            'email' => 'user3@mail.ru',
            'login' => 'user3',
            'password' => bcrypt('password'),
        ];
        $this->createUser(RBAC::Specialist, $params);
    }

    public function createUser(\App\Enums\RBAC $role, $params)
    {
        $user = User::where('login', $params['login'])
            ->orWhere('email', $params['email'])
            ->first();
        if (!$user) {
            $user = User::factory()->create($params);
            $foundRole = \App\Models\Role::findOrCreate($role->value);
            $user->assignRole($foundRole);
        }
        return $user;
    }

    public function getToken(string $login, string $password)
    {
        $token = "";
        $response = $this->post('/api/v1/login', [
            'login' => $login,
            'password' => $password,
        ]);
        $response->assertJsonStructure(['status',
            'message',
            'data' => [
                'token',
            ]]);
        if ($response->getStatusCode() == 200) {
            $result = json_decode($response->getContent(), true);
            return $result['data']['token'];
        }
        return "";
    }
}
