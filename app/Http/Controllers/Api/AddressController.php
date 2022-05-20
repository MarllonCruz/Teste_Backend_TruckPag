<?php

namespace App\Http\Controllers\Api;

use App\Actions\Address\AllAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\Address\CreateAddress;
use App\Actions\Address\UpdateAddress;
use App\Exceptions\CreateAddressException;
use App\Exceptions\UpdateAddressException;
use App\Http\Requests\AddressCreateRequest;
use App\Http\Requests\AddressUpdateRequest;
use App\Models\Address;
use Illuminate\Http\Response;

class AddressController extends Controller
{
    public function all(AllAddress $action)
    {   
        $addresses = $action->execute();
        return response()->json($addresses, Response::HTTP_OK);
    }


    public function store(AddressCreateRequest $request, CreateAddress $action)
    {   
        try {
            $response = $action->execute($request->validated());
            return response()->json($response, Response::HTTP_CREATED);

        } catch (CreateAddressException $exception) {
            return response()->json(['errors' => ['main' => $exception->getMessage()]], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(int $address_id, AddressUpdateRequest $request, UpdateAddress $action)
    {
        try {
            $response = $action->execute($request->validated(), $address_id);
            return response()->json($response, Response::HTTP_CREATED);

        } catch (UpdateAddressException $exception) {
            return response()->json(['errors' => ['main' => $exception->getMessage()]], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(int $address_id)
    {
        $address = Address::find($address_id);
        if (!$address) {
            return response()->json([
                    'errors' => ['main' => 'ID do endereço não foi encotrado no sistema']
                ], Response::HTTP_BAD_REQUEST);
        }

        $address->delete();
        return response()->json(['success' => 'Endereço removido com sucesso'], Response::HTTP_OK);
    }
}
