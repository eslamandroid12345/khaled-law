<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'service_id' => Service::factory(), // Creates a new service or associates with an existing one
            'question_ar' => $this->faker->sentence, // Generates a random Arabic sentence for the question
            'question_en' => $this->faker->sentence, // Generates a random English sentence for the question
            'answer_ar' => $this->faker->optional()->paragraph, // Generates a random Arabic paragraph for the answer or null
            'answer_en' => $this->faker->optional()->paragraph, // Generates a random English paragraph for the answer or null
        ];
    }
}
