<?php

namespace App\Http\Requests\API\V1;

use App\Http\Responses\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;

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
