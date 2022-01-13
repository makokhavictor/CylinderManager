<?php

namespace Database\Factories;

use App\Models\CanisterLogBatch;
use App\Models\Dealer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CanisterLogFactory extends Factory
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
            'canister_log_batch_id' => CanisterLogBatch::factory()->create()->id,
            'toable_id' => Dealer::factory()->create()->id,
            'toable_type' => Dealer::class
        ];
    }
}
