<?php

namespace Database\Factories;

use App\Models\CustomerReview;
use App\Models\Image;
use App\Models\Uses;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class UsesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title_ar' => $this->faker->name(),
            'title_en' => $this->faker->name(),
            'description_ar' => $this->faker->word(),
            'description_en' => $this->faker->word(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Uses $uses) {
            Image::factory()->create([
                'imageable_id' => $uses->id,
                'imageable_type' => Uses::class,
            ]);
        });
    }
}
