<?php

namespace App\Traits;

use App\Enums\RBAC;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;

trait RolesTrait
{
    protected User $currentUser;


    const MESSAGE_ACCESS_DENIED = 'ACCESS DENIED';
    const MESSAGE_USER_NOT_FOUND = 'ACCESS DENIED';

    public function isAdmin(): true|\Illuminate\Http\JsonResponse
    {
        return $this->isRole(RBAC::Admin);
    }

    public function isOperator(): true|\Illuminate\Http\JsonResponse
    {
        return $this->isRole(RBAC::Operator);
    }

    public function isSpecialist(): true|\Illuminate\Http\JsonResponse
    {
        return $this->isRole(RBAC::Specialist);
    }

    private function isRole(RBAC $role): true|\Illuminate\Http\JsonResponse
    {
        try {
            if (!$this->currentUser) {
                throw new \Exception(self::MESSAGE_USER_NOT_FOUND);
            }
            if (!$this->currentUser->hasRole($role)) {
                throw new \Exception(self::MESSAGE_USER_NOT_FOUND);
            }
        } catch (\Throwable $throwable) {
            return ApiResponse::error($throwable);
        }
        return true;
    }

}
