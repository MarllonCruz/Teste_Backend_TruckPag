<?php

namespace App\Actions\Address;

use App\Models\Address;
use Illuminate\Http\Response;
use Facades\App\Supports\Message;

class DestroyAddress 
{
    public function execute(int $address_id)
    {   
        if (!$address = Address::find($address_id)) {
            return response(
                Message::error('ID do endereço não foi encotrado no sistema'), 
                Response::HTTP_BAD_REQUEST
            );
        }

        $address->delete();
        return response(Message::success('Endereço removido com sucesso'), Response::HTTP_OK);
    }
}