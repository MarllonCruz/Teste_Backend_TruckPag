<?php

namespace Tests\Feature\app\Http\Controllers\Api\AddressController;

use Tests\TestCase;
use App\Models\City;
use App\Models\Address;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DestroyTest extends TestCase
{   
    use RefreshDatabase;

    /** @test */
    public function have_to_delete_the_address_an_confirm_with_in_db()
    {
        $city   = City::factory()->create();
        $address = Address::factory(['cidade_id' => $city->id])->create();

        $response = $this->json('delete', route('address.destroy', ['id' => $address->id]));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment([
            "success" => "Endereço removido com sucesso" 
        ]);

        $this->assertDatabaseMissing('addresses', [
            'id' =>  $address->id
        ]);
    }

    /** @test */
    public function have_to_return_invalid_no_exists_id_address_in_db()
    {   
        $id = rand(1111111111111, 999999999999);
        $response = $this->json('delete', route('address.destroy', ['id' => $id]));

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertJsonFragment([
            'errors' => ['main' => 'ID do endereço não foi encotrado no sistema']
        ]);
    }
}
