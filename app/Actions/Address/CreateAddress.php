<?php

namespace App\Actions\Address;

use App\Exceptions\CreateAddressException;
use App\Http\Requests\AddressCreateRequest;
use App\Models\Address;
use Illuminate\Support\Facades\Validator;

class CreateAddress 
{
    public function execute(array $data)
    {   
        $existsAddress = Address::query()
            ->where('logradouro', $data['logradouro'])
            ->where('numero', $data['numero'])
            ->where('bairro', $data['bairro'])
            ->where('cidade_id', $data['cidade_id'])
            ->first();

        if ($existsAddress) {
            throw new CreateAddressException('Esse endereço já existe no sistema');
        }

        $address = Address::query()->create($data); 
        return $this->formatDataReturn($address);
    }

    private function formatDataReturn(object $address)
    {   
        return [
            'id' => $address->id,
            'logradouro' => $address->logradouro,
            'numero'     => $address->numero,
            'bairro'     => $address->bairro,
            'cidade'     => [
                'id'   => $address->cidade->id,
                'nome' => $address->cidade->nome,
            ]
        ];
    }
}