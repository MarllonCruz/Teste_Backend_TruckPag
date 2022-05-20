<?php

namespace App\Services\IBGEAPI;

use App\Services\IBGEAPI\Exceptions\IBGENotFound;
use Illuminate\Support\Facades\Http;

/**
 * API e documentação 
 * https://servicodados.ibge.gov.br/api/docs/localidades#api-Municipios-estadosUFMunicipiosGet
 */
class IBGEAPI 
{   
    private $baseUrl = 'https://servicodados.ibge.gov.br/api/v1';

    public function cities(string $stateId)
    {
        $request = Http::get("{$this->baseUrl}/localidades/estados/{$stateId}/municipios");

        if ($request->status() !== 200) {
            throw new IBGENotFound();
        }

        return $request->json();
    }
}