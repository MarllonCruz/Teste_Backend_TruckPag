<?php

namespace App\Actions\Address;

use App\Models\Address;
use Illuminate\Http\Response;
use App\Exceptions\UpdateAddressException;

class UpdateAddress 
{
    public function execute(array $data, $address_id)
    {   
        $address = Address::find($address_id);
        
        if (!$address) {
            throw new UpdateAddressException('Esse ID do endereço não é foi encontrado no sistema');
        }

        if ($this->existsOtherAddress($data, $address)) {
            throw new UpdateAddressException('Esse endereço já existe no sistema');
        }

        $address->logradouro = $data['logradouro'] ?? $address->logradouro;
        $address->numero     = $data['numero']     ?? $address->numero;
        $address->bairro     = $data['bairro']     ?? $address->bairro;
        $address->cidade_id  = $data['cidade_id']  ?? $address->cidade_id;
        $address->save();

        return $this->formatDataReturn($address);
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