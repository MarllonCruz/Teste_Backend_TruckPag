<?php

namespace Tests\Feature\app\Http\Controllers\Api\CityController;

use Tests\TestCase;
use App\Models\City;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AllTest extends TestCase
{   
    use RefreshDatabase;

    /** @test */
    public function should_return_a_list_all_of_cities()
    {   
        City::factory(10)->create();

        $response = $this->json('get', route('city.all'));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                ['id', 'nome']
            ]
        ]);
    }

    /** @test */
    public function check_if_there_is_a_specific_cities_in_that_state_fake()
    {   
        $city1 = City::factory()->create();
        $city2 = City::factory()->create();

        $response = $this->json('get', route('city.all'));

        $response->assertJsonFragment([
            'nome' => $city1->nome,
            'nome' => $city2->nome
        ]);
    }

    /** @test */
    public function check_if_there_are_these_cities_created_is_in_the_db()
    {   
        $city1 = City::factory()->create();
        $city2 = City::factory()->create();
        
        $this->assertDatabaseHas('cities', [
            'id'   => $city1->id,
            'nome' => $city1->nome
        ]);
        $this->assertDatabaseHas('cities', [
            'id'   => $city2->id,
            'nome' => $city2->nome
        ]);
    }
}
