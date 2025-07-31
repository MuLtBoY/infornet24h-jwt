<?php

namespace App\Http\Requests\Purveyor;

use App\Rules\PurveyorExists;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class PurveyorDestroyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'purveyor_id' => ['required', 'integer', new PurveyorExists],
        ];
    }

    public function messages(): array
    {
        return [
            'purveyor_id.required' => 'O campo purveyor_id é obrigatório.',
            'purveyor_id.integer' => 'O campo purveyor_id deve ser um número inteiro.',
            'purveyor_id.exists' => 'O campo purveyor_id informado não existe.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        //
    }
}