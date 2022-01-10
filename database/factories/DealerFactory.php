<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DealerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'code' => $this->faker->randomNumber(7),
            'EPRA_licence_no' => $this->faker->randomNumber(7),
            'location' => $this->faker->city(),
            'GPS' => $this->faker->streetAddress(),
        ];
    }
}
