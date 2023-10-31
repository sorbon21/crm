<?php

namespace App\Http\Requests\API\V1;

use App\Http\Responses\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;

class SaveClientRequestRequest extends FormRequest
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
                'service_id' => 'sometimes|exists:services,id',
                'client_id' => 'sometimes|exists:clients,id',
                'operator_id' => 'sometimes|exists:users,id',
                'comment_id' => 'sometimes|exists:comments,id',
                'type' => 'sometimes|in:обращение,жалоба',
            ];
        }
        return [
            'service_id' => 'required|exists:services,id',
            'client_id' => 'required|exists:clients,id',
            'operator_id' => 'required|exists:users,id',
            'comment_id' => 'required|exists:comments,id',
            'type' => 'required|in:обращение,жалоба',
        ];
    }

    protected function failedValidation($validator)
    {
        $response = ApiResponse::warning($validator->getMessageBag());
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }

}
