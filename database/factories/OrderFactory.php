<?php

namespace Database\Factories;

use App\Models\Dealer;
use App\Models\Depot;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'depot_id' => Depot::factory()->create()->id,
            'dealer_id' => Dealer::factory()->create()->id
        ];
    }
}
