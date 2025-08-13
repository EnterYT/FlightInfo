<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FlightPassenger>
 */
class FlightPassengerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'year' => fake()->numberBetween(2020, 2025),
            'month' => fake()->numberBetween(1, 12),
            'category' => fake()->randomElement(['internal', 'international']),
            'passenger_count' => fake()->numberBetween(50, 5000),
        ];
    }
}
