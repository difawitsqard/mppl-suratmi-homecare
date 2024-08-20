<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Service;
use App\Models\OrderService;
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
            'customer_id' => User::factory(),
            'therapist_id' => null,
            'date' => fake()->dateTimeBetween('2024-07-01', '2025-12-30'),
            'status' => fake()->randomElement(['pending', 'approved', 'completed', 'canceled', 'rejected']),
            'note' => fake()->sentence(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (OrderService $orderService) {
            if ($orderService->status !== 'pending') {
                $orderService->update([
                    'therapist_id' => User::role('therapist')->get()->random()->id,
                ]);
            }
        });
    }
}
