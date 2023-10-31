<?php

namespace App\Http\Requests\API\V1;

use App\Http\Responses\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;

class SavePhoneRequest extends FormRequest
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
                'country_code' => 'sometimes|max:10',
                'phone' => 'sometimes|max:10',
            ];
        }
        return [
            'country_code' => 'required|max:10',
            'phone' => 'required|max:10',
        ];
    }

    protected function failedValidation($validator)
    {
        $response = ApiResponse::warning($validator->getMessageBag());
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }

}
