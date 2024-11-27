<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Image;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'category_id' => Category::factory(), // Creates a new category or associates with an existing one
            'name_ar' => $this->faker->word,          // Generates a random Arabic word
            'name_en' => $this->faker->word,      // Generates a random English word
            'price' => $this->faker->optional()->numberBetween(100, 1000), // Random price or null
            'desc_ar' => $this->faker->optional()->paragraph,  // Generates a random Arabic paragraph or null
            'desc_en' => $this->faker->optional()->paragraph,  // Generates a random English paragraph or null
            'required_files_ar' => $this->faker->optional()->sentence,  // Generates a random Arabic sentence or null
            'required_files_en' => $this->faker->optional()->sentence,  // Generates a random English sentence or null
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (Service $service) {
            Image::factory()->create([
                'imageable_id' => $service->id,
                'imageable_type' => Service::class,
            ]);
        });
    }
}
