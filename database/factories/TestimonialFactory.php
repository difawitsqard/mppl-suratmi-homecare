<?php

namespace Database\Factories;

use App\Models\OrderService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Testimonial>
 */
class TestimonialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_service_id' => OrderService::factory(),
            'content' => fake()->text(),
            'rating' => fake()->numberBetween(1, 5),
            'created_at' => fake()->dateTime(),
        ];
    }
}
