<?php

namespace Database\Factories;

use App\Models\Transporter;
use App\Models\TransporterUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransporterUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TransporterUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'transporter_id' => Transporter::factory()->create()->id,
            'user_id' => User::factory()->create()->id
        ];
    }
}
