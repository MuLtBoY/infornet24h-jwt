<?php

namespace App\Http\Requests\Purveyor;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class PurveyorUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => $this->purveyor_id
        ]);
    }

    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:purveyors,id',
            'name' => 'required_without_all:street,neighborhood,number,latitude,longitude,city,uf|string',
            'street' => 'required_without_all:name,neighborhood,number,latitude,longitude,city,uf|string',
            'neighborhood' => 'required_without_all:name,street,number,latitude,longitude,city,uf|string',
            'number' => 'required_without_all:name,street,neighborhood,latitude,longitude,city,uf|integer',
            'latitude' => 'required_without_all:name,street,neighborhood,number,longitude,city,uf|numeric',
            'longitude' => 'required_without_all:name,street,neighborhood,number,latitude,city,uf|numeric',
            'city' => 'required_without_all:name,street,neighborhood,number,latitude,longitude,uf|string',
            'uf' => 'required_without_all:name,street,neighborhood,number,latitude,longitude,city|string|size:2',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'O campo purveyor_id é obrigatório.',
            'id.integer' => 'O campo purveyor_id deve ser um número inteiro.',
            'id.exists' => 'O campo purveyor_id informado não existe.',
            'name.string' => 'O name deve ser um texto.',
            'street.string' => 'A street deve ser um texto.',
            'neighborhood.string' => 'O neighborhood deve ser um texto.',
            'number.integer' => 'O number deve ser um número inteiro.',
            'latitude.numeric' => 'A latitude deve ser numérica.',
            'longitude.numeric' => 'A longitude deve ser numérica.',
            'city.string' => 'A city deve ser um texto.',
            'uf.string' => 'A uf deve ser um texto.',
            'uf.size' => 'A uf deve ter exatamente 2 caracteres.',
            'name.required_without_all' => 'Você deve informar pelo menos um dos campos: name,street,neighborhood,number,latitude,longitude,city ou uf.',
            'street.required_without_all' => 'Você deve informar pelo menos um dos campos: name,street,neighborhood,number,latitude,longitude,city ou uf.',
            'neighborhood.required_without_all' => 'Você deve informar pelo menos um dos campos: name,street,neighborhood,number,latitude,longitude,city ou uf.',
            'number.required_without_all' => 'Você deve informar pelo menos um dos campos: name,street,neighborhood,number,latitude,longitude,city ou uf.',
            'latitude.required_without_all' => 'Você deve informar pelo menos um dos campos: name,street,neighborhood,number,latitude,longitude,city ou uf.',
            'longitude.required_without_all' => 'Você deve informar pelo menos um dos campos: name,street,neighborhood,number,latitude,longitude,city ou uf.',
            'city.required_without_all' => 'Você deve informar pelo menos um dos campos: name,street,neighborhood,number,latitude,longitude,city ou uf.',
            'uf.required_without_all' => 'Você deve informar pelo menos um dos campos: name,street,neighborhood,number,latitude,longitude,city ou uf.',
        ];
    }

    protected function failedValidation(Validator $validator) 
    {   
        //
    }
}