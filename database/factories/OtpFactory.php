<?php

namespace Database\Factories;

use App\Models\Otp;
use Illuminate\Database\Eloquent\Factories\Factory;
use function Aws\boolean_value;

class OtpFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Otp::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'identifier' => $this->faker->phoneNumber(),
            'token' => $this->faker->randomNumber(6),
            'validity' => $this->faker->randomNumber(2),
            'valid' => $this->faker->boolean(),
            'usage' => ['reset-password', 'confirm-transaction', 'verify-account'][array_rand([0, 1, 2])]
        ];
    }
}
