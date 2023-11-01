<?php

namespace App\Http\Requests\API\V1;

use App\Http\Responses\ApiResponse;
use App\Rules\FindLoginRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login' => [
                'required',
                'string',
                new FindLoginRule(),
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
