<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class ConsultationFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['ONLINE', 'OFFLINE']),
            'status' => $this->faker->randomElement(['PAIED', 'UNPAIED']),  // Fixed typo in status values
            'user_id' => User::factory(),
            'name' => $this->faker->name(),
            'id_number' => $this->faker->unique()->numerify('##########'), // Ensures unique 10-digit number
            'address' => $this->faker->address(),  // Using address instead of text for more realistic data
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'subject' => $this->faker->sentence(3), // Creates a short title instead of using the 'title' method
            'legal_question' => $this->faker->sentence(), // Shortened for a more concise question
            'description' => $this->faker->paragraph(),  // Provides a more realistic paragraph of text
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
