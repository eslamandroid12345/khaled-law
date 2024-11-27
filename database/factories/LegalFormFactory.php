<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\LegalForm;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class LegalFormFactory extends Factory
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
                    'name_ar' => $this->faker->name(),
                    'name_en' => $this->faker->name(),
                    'description_ar' => $this->faker->paragraph(),  // Generates a realistic paragraph in Arabic
                    'description_en' => $this->faker->paragraph(),  // Generates a realistic paragraph in English
                    'price' => $this->faker->randomFloat(2, 10, 1000),  // Generates a realistic price between 10 and 1000
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

    public function configure()
    {
        return $this->afterCreating(function (LegalForm $legalform) {
            Image::factory()->create([
                'imageable_id' => $legalform->id,
                'imageable_type' => LegalForm::class,
            ]);
        });
    }
}
