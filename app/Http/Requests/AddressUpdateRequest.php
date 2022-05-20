<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'logradouro' => 'string|max:255',
            'numero'     => 'string|max:225',
            'bairro'     => 'string|max:255',
            'cidade_id'  => 'integer|exists:App\Models\City,id'
        ];
    }

    public function messages()
    {   
        return [
            'logradouro.string'   => 'Tem que ser tipo string',
            'logradouro.max'      => 'Limite de caracteres é 255',
            
            'numero.string'   => 'Tem que ser tipo string',
            'numero.max'      => 'Limite de caracteres é 255',

            'bairro.string'   => 'Tem que ser tipo string',
            'bairro.max'      => 'Limite de caracteres é 255',

            'cidade_id.integer'  => 'Campo tem que tipo inteiro',
            'cidade_id.exists'   => 'ID da cidade selecionado não encontrado no sistema'
        ];
    }
}
