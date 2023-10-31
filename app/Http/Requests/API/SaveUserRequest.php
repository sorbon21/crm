<?php

namespace App\Http\Requests\API;

use App\Http\Responses\ApiResponse;
use App\Rules\FindLoginRule;
use App\Rules\IsEmailExistRule;
use App\Rules\IsLoginExistRule;
use App\Rules\IsRoleAllowedToAssignRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return [
                'name' => 'sometimes|string',
                'role' => [
                    'sometimes',
                    'string',
                    new IsRoleAllowedToAssignRule()
                ],
                'password' => 'required|string',
            ];
        }

        return [
            'name' => 'required|string',
            'login' => [
                'required',
                'string',
                new IsLoginExistRule()
            ],
            'email' => [
                'required',
                'email',
                new IsEmailExistRule()
            ],
            'role' => [
                'required',
                'string',
                new IsRoleAllowedToAssignRule()
            ],
            'password' => 'required|string',
        ];
    }

    protected function failedValidation($validator)
    {
        $response = ApiResponse::warning($validator->getMessageBag());
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }

}
