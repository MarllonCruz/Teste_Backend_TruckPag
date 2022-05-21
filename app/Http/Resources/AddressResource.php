<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'logradouro' => $this->logradouro,
            'numero'     => $this->numero,
            'bairro'     => $this->bairro,
            'cidade'     => [
                'id'   => $this->cidade->id,
                'nome' => $this->cidade->nome
            ]
        ];
    }
}
