<?php

namespace App\Http\Requests\Assistance;

use App\Rules\AssistanceExists;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class AssistanceDestroyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'assistance_id' => ['required', 'integer', new AssistanceExists],
        ];
    }

    public function messages(): array
    {
        return [
            'assistance_id.required' => 'O campo assistance_id é obrigatório.',
            'assistance_id.integer' => 'O campo assistance_id deve ser um número inteiro.',
            'assistance_id.exists' => 'O campo assistance_id informado não existe.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        //
    }
}