<?php

namespace App\Http\Requests\Geocode;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class GeocodeByAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'address' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'address.required' => 'O address é obrigatório.',
            'address.string' => 'O address deve ser um texto.',
        ];
    }

    protected function failedValidation(Validator $validator) 
    {   
        //
    }
}
