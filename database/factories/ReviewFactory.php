<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'review_id' => Order::factory(), // Creates a new service or associates with an existing one
            'lawyer_id' => User::where('type', 'LAWYER')->inRandomOrder()->value('id'), // Randomly pick a lawyer
            'user_id' => User::where('type', 'USER')->inRandomOrder()->value('id'), // Randomly pick a user
            'message' => $this->faker->optional()->text,  // Random review message or null
            'rate' => $this->faker->numberBetween(1, 5),   // Random rating between 1 and 5
        ];
    }
}
