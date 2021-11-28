<?php

namespace Database\Factories;

use App\Models\Dealer;
use App\Models\DealerUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DealerUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create()->id,
            'dealer_id' => Dealer::factory()->create()->id
        ];
    }
}
