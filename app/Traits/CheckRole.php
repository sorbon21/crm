<?php

namespace App\Traits;

use App\Enums\RBAC;
use App\Models\User;

trait CheckRole
{
    const ACCESS_DENIED_MESSAGE = 'Access denied';

    public function isAdmin(User $user): bool
    {
        return $user->hasRole(RBAC::Admin);
    }

    public function isOperator(User $user): bool
    {
        return $user->hasRole(RBAC::Operator);
    }

    public function isSpecialist(User $user): bool
    {
        return $user->hasRole(RBAC::Specialist);
    }
}
