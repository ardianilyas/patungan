<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Topup>
 */
class TopupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::all()->random()->id,
            'external_id' => 'Topup-' . uniqid(),
            'amount' => rand(10000, 200000),
            'status' => $this->faker->randomElement(['pending', 'paid', 'failed']),
        ];
    }
}
