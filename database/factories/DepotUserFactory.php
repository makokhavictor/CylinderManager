<?php

namespace Database\Factories;

use App\Models\DepotUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepotUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DepotUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create()->id,
        ];
    }
}
