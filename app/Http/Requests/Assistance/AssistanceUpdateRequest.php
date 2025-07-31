<?php

namespace App\Http\Requests\Assistance;

use App\Rules\AssistanceExists;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class AssistanceUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => $this->assistance_id
        ]);
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', new AssistanceExists],
            'name' => 'required_without_all:status|string',
            'status' => 'required_without_all:name|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'O campo assistance_id é obrigatório.',
            'id.integer' => 'O campo assistance_id deve ser um número inteiro.',
            'id.exists' => 'O campo assistance_id informado não existe.',
            'name.string' => 'O campo name deve ser um texto.',
            'status.bool' => 'O status deve ser um valor booleano (true ou false).',
            'name.required_without_all' => 'Você deve informar pelo menos um dos campos: name ou status.',
            'status.required_without_all' => 'Você deve informar pelo menos um dos campos: name ou status.',
        ];
    }

    protected function failedValidation(Validator $validator) 
    {   
        //
    }
}