<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'logradouro' => 'required|string|max:255',
            'numero'     => 'required|string|max:225',
            'bairro'     => 'required|string|max:255',
            'cidade_id'  => 'required|integer|exists:App\Models\City,id'
        ];
    }

    public function messages()
    {   
        return [
            'logradouro.required' => 'Campo é obrigatório',
            'logradouro.string'   => 'Tem que ser tipo string',
            'logradouro.max'      => 'Limite de caracteres é 255',
            
            'numero.required' => 'Campo é obrigatório',
            'numero.string'   => 'Tem que ser tipo string',
            'numero.max'      => 'Limite de caracteres é 255',

            'bairro.required' => 'Campo é obrigatório',
            'bairro.string'   => 'Tem que ser tipo string',
            'bairro.max'      => 'Limite de caracteres é 255',

            'cidade_id.required' => 'Campo é obrigatório',
            'cidade_id.integer'  => 'Campo tem que tipo inteiro',
            'cidade_id.exists'   => 'ID da cidade selecionado não encontrado no sistema'
        ];
    }
}
