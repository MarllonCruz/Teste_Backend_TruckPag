<?php

namespace Tests\Feature\app\Http\Controllers\Api\AddressController;

use Tests\TestCase;
use App\Models\City;
use App\Models\Address;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AllTest extends TestCase
{   
    use RefreshDatabase;
    
    /** @test */
    public function should_return_a_list_of_address_by_paginate_15()
    {   
        $city = City::factory()->create();

        Address::factory(16, [
            'cidade_id' => $city->id
        ])->create();
        
        $response = $this->json('get', route('address.all'));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(15, 'data');
        $response->assertJsonStructure([
            'data' => [
                ['id', 'logradouro', 'numero', 'bairro', 'cidade']
            ],
            'links',
            'meta'
        ]);
    }

    /** @test */
    public function check_if_there_is_a_specific_addresses_fake()
    {   
        $city     = City::factory()->create();
        $address1 = Address::factory(['cidade_id' => $city->id])->create();
        $address2 = Address::factory(['cidade_id' => $city->id])->create();

        $response = $this->json('get', route('address.all'));

        $response
            ->assertJsonFragment([
                'id' => $address1->id,
                'id' => $address2->id
            ]);
    }

    /** @test */
    public function check_if_there_are_these_addresses_created_is_in_the_db()
    {   
        $city     = City::factory()->create();
        $address1 = Address::factory(['cidade_id' => $city->id])->create();
        $address2 = Address::factory(['cidade_id' => $city->id])->create();
            
        $this->assertDatabaseHas('addresses', [
            'id'         => $address1->id,
            'logradouro' => $address1->logradouro
        ]);
        $this->assertDatabaseHas('addresses', [
            'id'         => $address2->id,
            'logradouro' => $address2->logradouro
        ]);
    }
}
