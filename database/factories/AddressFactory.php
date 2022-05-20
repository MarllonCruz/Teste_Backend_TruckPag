<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'logradouro' => $this->faker->streetName(),
            'numero'     => $this->faker->buildingNumber(),
            'bairro'     => $this->faker->streetName(),
        ];
    }
}
