<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'O campo de email é obrigatório.',
            'email.string'      => 'O email deve ser um texto.',
            'email.email'       => 'O email deve ser um endereço válido.',
            
            'password.required' => 'O campo password é obrigatório.',
            'password.string'   => 'O campo password deve ser um texto.',
        ];
    }

    protected function failedValidation(Validator $validator) 
    {   
        //
    }
}