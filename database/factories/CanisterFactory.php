<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class CanisterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->randomNumber(7),
            'manuf' => $this->faker->company(),
            'manuf_date' => $this->faker->date(),
            'brand_id' => Brand::factory()->create()->id,
            'RFID' => $this->faker->randomNumber(7),
            'QR' => $this->faker->randomNumber(7),
            'recertification' => $this->faker->date(),
        ];
    }
}
