<?php

namespace App\Actions\Address;

use App\Exceptions\CreateAddressException;
use App\Models\Address;

class AllAddress 
{
    public function execute()
    {   
        $addresses = Address::all();

        return $this->formatDataReturn($addresses);
    }

    private function formatDataReturn(object $addresses)
    {   
        $data = [];

        foreach ($addresses as $address) {
            $data[] = [
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

        return $data;
    }
}