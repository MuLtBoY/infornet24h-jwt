<?php

namespace App\Http\Requests\Purveyor;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class PurveyorStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'street' => 'required|string',
            'neighborhood' => 'required|string',
            'number' => 'required|integer',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'city' => 'required|string',
            'uf' => 'required|string|size:2',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo name é obrigatório.',
            'name.string' => 'O campo name deve ser um texto.',
            'street.required' => 'O campo street é obrigatório.',
            'street.string' => 'O campo street deve ser um texto.',
            'neighborhood.required' => 'O campo neighborhood é obrigatório.',
            'neighborhood.string' => 'O campo neighborhood deve ser um texto.',
            'number.required' => 'O campo number é obrigatório.',
            'number.integer' => 'O campo number deve ser um número inteiro.',
            'latitude.required' => 'O campo latitude é obrigatório.',
            'latitude.numeric' => 'O campo latitude deve ser um número.',
            'longitude.required' => 'O campo longitude é obrigatório.',
            'longitude.numeric' => 'O campo longitude deve ser um número.',
            'city.required' => 'O campo city é obrigatório.',
            'city.string' => 'O campo city deve ser um texto.',
            'uf.required' => 'O campo uf é obrigatório.',
            'uf.string' => 'O campo uf deve ser um texto.',
            'uf.size' => 'O campo uf deve conter exatamente 2 caracteres.',
        ];
    }

    protected function failedValidation(Validator $validator) 
    {   
        //
    }
}