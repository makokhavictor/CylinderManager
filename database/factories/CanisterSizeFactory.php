<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\CanisterSize;
use Illuminate\Database\Eloquent\Factories\Factory;

class CanisterSizeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $size = $this->faker->randomDigitNotNull();
        return [
            'value' => $size,
            'name' => $size.'Kg',
        ];
    }
}
