<?php

namespace App\Http\Requests\Purveyor;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class PurveyorSearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'filters' => 'sometimes|array',
            'filters.city'   => 'sometimes|string|max:70',
            'filters.uf'     => 'sometimes|string|size:2',
            'filters.provider_status' => 'sometimes|string|in:online,offline',

            'assistance_id' => 'required|integer|exists:assistances,id',

            'origin_city' => 'required|string|max:70',
            'origin_uf'   => 'required|string|size:2',
            'origin_latitude' => 'required|numeric',
            'origin_longitude' => 'required|numeric',

            'destiny_city' => 'required|string|max:70',
            'destiny_uf'   => 'required|string|size:2',
            'destiny_latitude' => 'required|numeric',
            'destiny_longitude' => 'required|numeric',

            'sort'     => 'sometimes|array',
            'sort.*'   => 'in:city,uf,provider_status,value,distance',
            'quantity' => 'numeric|min:1|max:100'
        ];
    }

    public function messages(): array
    {
        return [
            'filters.array'             => 'O campo de filters deve ser um array.',
            'filters.city.string'       => 'A city deve ser um texto.',
            'filters.city.max'          => 'A city deve ter no máximo 70 caracteres.',
            'filters.uf.string'         => 'A uf deve ser um texto.',
            'filters.uf.size'           => 'A uf deve ter exatamente 2 caracteres.',
            'filters.status.string'     => 'O status deve ser um texto.',
            'filters.status.in'         => 'O status deve ser "online" ou "offline".',
            'origin_city.required'      => 'O campo origin_city é obrigatório.',
            'origin_city.string'        => 'O campo origin_city deve ser um texto.',
            'origin_city.max'           => 'O campo origin_city deve ter no máximo 70 caracteres.',
            'origin_uf.required'        => 'O campo origin_uf é obrigatório.',
            'origin_uf.string'          => 'O campo origin_uf deve ser um texto.',
            'origin_uf.size'            => 'O campo origin_uf deve ter exatamente 2 caracteres.',
            'origin_latitude.required'  => 'O campo origin_latitude é obrigatório.',
            'origin_latitude.numeric'   => 'O campo origin_latitude deve ser um número.',
            'destiny_city.required'     => 'O campo destiny_city é obrigatório.',
            'destiny_city.string'       => 'O campo destiny_city deve ser um texto.',
            'destiny_city.max'          => 'O campo destiny_city deve ter no máximo 70 caracteres.',
            'destiny_uf.required'       => 'O campo destiny_uf é obrigatório.',
            'destiny_uf.string'         => 'O campo destiny_uf deve ser um texto.',
            'destiny_uf.size'           => 'O campo destiny_uf deve ter exatamente 2 caracteres.',
            'destiny_latitude.required' => 'O campo destiny_latitude é obrigatório.',
            'destiny_latitude.numeric'  => 'O campo destiny_latitude deve ser um número.',
            'assistance_id.required'    => 'O campo assistance_id é obrigatório.',
            'assistance_id.integer'     => 'O assistance_id deve ser um número inteiro.',
            'assistance_id.exists'      => 'O assistance_id informado não foi encontrado.',
            'sort.array'                => 'O campo de ordenação deve ser um array.',
            'sort.*.in'                 => 'Ordenação inválida. Use: city, uf, status, value ou distance.',
            'quantity.numeric'          => 'O campo quantity deve ser um número.',
            'quantity.min'              => 'O campo quantity deve ter valor mínimo de 1.',
            'quantity.max'              => 'O campo quantity deve ter valor máximo de 100.',
        ];
    }

    protected function failedValidation(Validator $validator) 
    {   
        //
    }
}
