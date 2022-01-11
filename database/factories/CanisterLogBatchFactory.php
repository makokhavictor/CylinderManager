<?php

namespace Database\Factories;

use App\Models\CanisterLogBatch;
use App\Models\Dealer;
use App\Models\Depot;
use App\Models\Transporter;
use Illuminate\Database\Eloquent\Factories\Factory;

class CanisterLogBatchFactory extends Factory
{
    protected $model = CanisterLogBatch::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fromable_id' => Depot::factory()->create(),
            'fromable_type' => Depot::class,
            'toable_id' => Dealer::factory()->create(),
            'toable_type' => Dealer::class,
            'transporter_id' => Transporter::factory()->create()->id
        ];
    }
}
