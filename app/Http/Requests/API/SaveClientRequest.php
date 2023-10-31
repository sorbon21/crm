<?php

namespace App\Http\Requests\API;

use App\Http\Responses\ApiResponse;
use App\Rules\FindLoginRule;
use App\Rules\IsEmailExistRule;
use App\Rules\IsLoginExistRule;
use App\Rules\IsRoleAllowedToAssignRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveClientRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|trim',
            'phone_id' => 'required|number',
        ];
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules = [
                'name' => 'sometimes|string|trim',
                'phone_id' => 'sometimes|number',
            ];
        }
        return $rules;

    }

    protected function failedValidation($validator)
    {
        $response = ApiResponse::warning($validator->getMessageBag());
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }

}
