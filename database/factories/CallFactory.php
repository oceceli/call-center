<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Call>
 */
class CallFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'customer_id' => rand(1, 50),
            'status' => $this->faker->randomElement(['positive', 'unanswered', 'busy']),
            'score' => random_int(1, 10),
            'note' => $this->faker->sentence(5),
        ];
    }
}
