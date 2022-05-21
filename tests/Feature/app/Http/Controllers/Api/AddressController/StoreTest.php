<?php

namespace Tests\Feature\app\Http\Controllers\Api\AddressController;

use Tests\TestCase;
use App\Models\City;
use App\Models\Address;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function must_validate_and_save_in_db()
    {   
        $city = City::factory()->create();

        $payload = [
            'logradouro' => 'Rua de tal',
            'numero'     => '333',
            'bairro'     => 'Bairro de tal',
            'cidade_id'  => $city->id
        ];

        $response = $this->json('post', route('address.store'), $payload);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonFragment([
            'logradouro' => 'Rua de tal',
            'numero'     => '333',
            'bairro'     => 'Bairro de tal',
            'cidade'     => [
                'id'   => $city->id,
                'nome' => $city->nome
            ] 
        ]);

        $this->assertDatabaseHas('addresses', [
            'logradouro' => 'Rua de tal',
            'numero'     => '333',
            'bairro'     => 'Bairro de tal',
            'cidade_id'  => $city->id 
        ]);
    }

    /** @test */
    public function have_to_return_invalid_required_in_attributes()
    {
        $city = City::factory()->create();

        $payload = [
            'logradouro' => '',
            'numero'     => '',
            'bairro'     => '',
            'cidade_id'  => $city->id
        ];

        $response = $this->json('post', route('address.store'), $payload);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonFragment([
            "errors" => [
                "logradouro" => [
                    "Campo é obrigatório"
                ],
                "numero" => [
                    "Campo é obrigatório"
                ],
                "bairro" => [
                    "Campo é obrigatório"
                ],
            ]
        ]);
    }

    /** @test */
    public function have_to_return_invalid_maximum_characters_255_in_attributes()
    {
        $city = City::factory()->create();

        $payload = [
            'logradouro' => str_repeat('a', 256),
            'numero'     => str_repeat('a', 256),
            'bairro'     => str_repeat('a', 256),
            'cidade_id'  => $city->id
        ];

        $response = $this->json('post', route('address.store'), $payload);

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
        $city = City::factory()->create();

        $payload = [
            'logradouro' => 111,
            'numero'     => 222,
            'bairro'     => 333,
            'cidade_id'  => $city->id
        ];

        $response = $this->json('post', route('address.store'), $payload);

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
        $payload = [
            'logradouro' => 'Rua de tal',
            'numero'     => '333',
            'bairro'     => 'Bairro de tal',
            'cidade_id'  => rand(1111111111, 999999999)
        ];

        $response = $this->json('post', route('address.store'), $payload);

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
    public function have_to_return_invalid_because_this_address_already_exists_in_db()
    {   
        $city = City::factory()->create();

        $address = Address::factory([
            'cidade_id' => $city->id
        ])->create();

        $payload = [
            'logradouro' => $address->logradouro,
            'numero'     => $address->numero,
            'bairro'     => $address->bairro,
            'cidade_id'  => $address->cidade_id
        ];

        $response = $this->json('post', route('address.store'), $payload);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertJsonFragment([
            "errors" => [
                "main" => "Esse endereço já existe no sistema",
            ]
        ]);
    }
}
