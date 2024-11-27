<?php

namespace Database\Factories;

use App\Models\CustomerReview;
use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CustomerReviewFactory extends Factory
{
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
            'review_ar' => $this->faker->word(),
            'review_en' => $this->faker->word(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (CustomerReview $customerReview) {
            Image::factory()->create([
                'imageable_id' => $customerReview->id,
                'imageable_type' => CustomerReview::class,
            ]);
        });
    }
}
