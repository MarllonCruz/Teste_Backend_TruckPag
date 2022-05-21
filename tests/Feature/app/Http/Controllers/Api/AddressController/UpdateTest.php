<?php

namespace Tests\Feature\app\Http\Controllers\Api\AddressController;

use Tests\TestCase;
use App\Models\City;
use App\Models\Address;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateTest extends TestCase
{   
    use RefreshDatabase;
    
    /** @test */
    public function must_validate_and_save_in_db()
    {
        $city    = City::factory()->create();
        $address = Address::factory(['cidade_id' => $city->id])->create();

        $payload = [
            'logradouro' => 'Rua logradoura editado'
        ];

        $response = $this->json('post', route('address.update', ['id' => $address->id]), $payload);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment([
            "id"         =>  $address->id,
            'logradouro' => 'Rua logradoura editado',
            'numero'     =>  $address->numero,
            'bairro'     =>  $address->bairro,
            'cidade'     => [
                'id'   => $city->id,
                'nome' => $city->nome
            ] 
        ]);

        $this->assertDatabaseHas('addresses', [
            'logradouro' => 'Rua logradoura editado',
            'numero'     =>  $address->numero,
            'bairro'     =>  $address->bairro,
            'cidade_id'  =>  $address->cidade_id 
        ]);
    }

    /** @test */
    public function have_to_return_invalid_maximum_characters_255_in_attributes()
    {
        $city    = City::factory()->create();
        $address = Address::factory(['cidade_id' => $city->id])->create();

        $payload = [
            'logradouro' => str_repeat('a', 256),
            'numero'     => str_repeat('a', 256),
            'bairro'     => str_repeat('a', 256),
            'cidade_id'  => $address->cidade_id
        ];

        $response = $this->json('post', route('address.update', ['id' => $address->id]), $payload);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonFragment([
            "errors" => [
                "logradouro" => [
                    "Limite de caracteres é 255"
                ],
                "numero" => [
                    "Limite de caracteres é 255"
                ],
                "bairro" => [
                    "Limite de caracteres é 255"
                ],
            ]
        ]);
    }

    /** @test */
    public function have_to_return_invalid_string_in_attributes()
    {
        $city    = City::factory()->create();
        $address = Address::factory(['cidade_id' => $city->id])->create();

        $payload = [
            'logradouro' => 111,
            'numero'     => 222,
            'bairro'     => 333,
            'cidade_id'  => $address->cidade_id
        ];

        $response = $this->json('post', route('address.update', ['id' => $address->id]), $payload);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonFragment([
            "errors" => [
                "logradouro" => [
                    "Tem que ser tipo string"
                ],
                "numero" => [
                    "Tem que ser tipo string"
                ],
                "bairro" => [
                    "Tem que ser tipo string"
                ],
            ]
        ]);
    }

    /** @test */
    public function have_to_return_invalid_no_exists_id_cities_in_db()
    {
        $city    = City::factory()->create();
        $address = Address::factory(['cidade_id' => $city->id])->create();

        $payload = [
            'cidade_id'  => $address->cidade_id . rand(5, 9)
        ];

        $response = $this->json('post', route('address.update', ['id' => $address->id]), $payload);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonFragment([
            "errors" => [
                "cidade_id" => [
                    "ID da cidade selecionado não encontrado no sistema"
                ]
            ]
        ]);
    }

    /** @test */
    public function have_to_return_invalid_that_another_address_already_exists()
    {
        $city    = City::factory()->create();
        $address1 = Address::factory(['cidade_id' => $city->id])->create();
        $address2 = Address::factory(['cidade_id' => $city->id])->create();

        $payload = [
            'logradouro' => $address1->logradouro,
            'numero'     => $address1->numero,
            'bairro'     => $address1->bairro,
            'cidade_id'  => $address1->cidade_id
        ];

        $response = $this->json('post', route('address.update', ['id' => $address2->id]), $payload);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertJsonFragment([
            "errors" => [
                "main" => "Esse endereço já existe no sistema"
            ]
        ]);
    }	
}
