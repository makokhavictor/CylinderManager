<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DepotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->city(),
            'code' => $this->faker->randomNumber(6),
            'EPRA_licence_no' => $this->faker->randomNumber(6),
            'location' => $this->faker->city()
        ];
    }
}
