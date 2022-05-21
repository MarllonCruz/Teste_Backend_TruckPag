<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use App\Http\Controllers\Controller;
use App\Http\Resources\AddressResource;
use App\Http\Requests\AddressCreateRequest;
use App\Http\Requests\AddressUpdateRequest;
use Facades\App\Actions\Address\CreateAddress;
use Facades\App\Actions\Address\DestroyAddress;
use Facades\App\Actions\Address\UpdateAddress;

class AddressController extends Controller
{
    public function all()
    {   
        return AddressResource::collection(Address::paginate());
    }

    public function store(AddressCreateRequest $request)
    {   
        return CreateAddress::execute($request->validated());
    }

    public function update(int $address_id, AddressUpdateRequest $request)
    {
        return UpdateAddress::execute($request->validated(), $address_id);
    }

    public function destroy(int $id_address)
    {
        return DestroyAddress::execute($id_address);
    }
}
