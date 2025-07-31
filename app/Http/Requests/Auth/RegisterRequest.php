<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo name é obrigatório.',
            'name.string'   => 'O campo name deve ser um texto.',
            'name.max'      => 'O campo name não pode ter mais que 255 caracteres.',
            'email.required' => 'O campo email é obrigatório.',
            'email.string'   => 'O campo email deve ser um texto.',
            'email.email'    => 'O campo email deve ser um endereço de e-mail válido.',
            'email.max'      => 'O campo email não pode ter mais que 255 caracteres.',
            'email.unique'   => 'Este e-mail já está sendo utilizado.',
            'password.required'  => 'O campo password é obrigatório.',
            'password.string'    => 'O campo password deve ser um texto.',
            'password.min'       => 'O campo password deve ter no mínimo 6 caracteres.',
            'password.confirmed' => 'A confirmação da senha não confere.',
        ];
    }

    protected function failedValidation(Validator $validator) 
    {   
        //
    }
}