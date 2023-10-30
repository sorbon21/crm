<?php

namespace App\Rules;

use App\Enums\RBAC;
use App\Models\Role;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IsRoleAllowedToAssignRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!in_array($value, [RBAC::Specialist->value, RBAC::Operator->value])) {
            $fail('role not found in system');
        } elseif (!Role::findByName($value)) {
            $fail('role not found in system');
        }
    }
}
