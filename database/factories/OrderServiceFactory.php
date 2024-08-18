<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderService>
 */
class OrderServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'service_id' => Service::factory(),
            'user_id' => User::factory(),
            'date' => fake()->dateTimeBetween('2024-07-01', '2025-12-30')->format('Y-m-d'),
            'status' => fake()->randomElement(['pending', 'approved', 'completed', 'canceled', 'rejected']),
            'note' => fake()->sentence(),
        ];
    }
}
