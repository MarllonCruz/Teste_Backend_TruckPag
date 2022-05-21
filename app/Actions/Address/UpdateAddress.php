<?php

namespace App\Actions\Address;

use App\Models\Address;
use Illuminate\Http\Response;
use Facades\App\Supports\Message;
use App\Http\Resources\AddressResource;

class UpdateAddress 
{
    public function execute(array $data, $address_id)
    {   
        if (!$address = Address::find($address_id)) {
            return response(
                Message::error('Esse ID do endereço não é foi encontrado no sistema'),Response::HTTP_BAD_REQUEST
            );
        }

        if ($this->existsOtherAddress($data, $address)) {
            return response(
                Message::error('Esse endereço já existe no sistema'), Response::HTTP_BAD_REQUEST
            );
        }

        $address->logradouro = $data['logradouro'] ?? $address->logradouro;
        $address->numero     = $data['numero']     ?? $address->numero;
        $address->bairro     = $data['bairro']     ?? $address->bairro;
        $address->cidade_id  = $data['cidade_id']  ?? $address->cidade_id;
        $address->save();

        return AddressResource::make($address);
    }

    private function existsOtherAddress($data, Address $address): bool
    {
        $logradouro = $data['logradouro'] ?? $address->logradouro;
        $numero     = $data['numero']     ?? $address->numero;
        $bairro     = $data['bairro']     ?? $address->bairro;
        $cidade_id  = $data['cidade_id']  ?? $address->cidade_id;
        

        $data = Address::query()
            ->where('logradouro', $logradouro)
            ->where('numero', $numero)
            ->where('bairro', $bairro)
            ->where('cidade_id', $cidade_id)
            ->first();

        return $data ? true : false;
    }
}