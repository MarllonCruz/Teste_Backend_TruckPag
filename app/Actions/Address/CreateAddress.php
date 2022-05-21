<?php

namespace App\Actions\Address;

use App\Models\Address;
use Illuminate\Http\Response;
use App\Http\Resources\AddressResource;
use Facades\App\Supports\Message;

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
            return response(Message::error('Esse endereço já existe no sistema'), Response::HTTP_BAD_REQUEST);
        }

        $address = Address::create($data);

        return AddressResource::make($address);
    }
}