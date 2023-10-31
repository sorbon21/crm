<?php

namespace App\Http\Requests\API;

use App\Http\Responses\ApiResponse;
use App\Rules\FindLoginRule;
use App\Rules\IsEmailExistRule;
use App\Rules\IsLoginExistRule;
use App\Rules\IsRoleAllowedToAssignRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveRequestStatusRequest extends FormRequest
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
                'request_id' => 'sometimes|exists:requests,id',
                'specialist_id' => 'sometimes|exists:users,id',
                'comment_id' => 'sometimes|exists:comments,id',
                'status' => 'sometimes|string|max:255',
            ];
        }
        return [
            'request_id' => 'required|exists:requests,id',
            'specialist_id' => 'required|exists:users,id',
            'comment_id' => 'required|exists:comments,id',
            'status' => 'required|string|max:255',
        ];
    }

    protected function failedValidation($validator)
    {
        $response = ApiResponse::warning($validator->getMessageBag());
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }

}
