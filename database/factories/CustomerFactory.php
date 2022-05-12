<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => null,
            'name' => $this->faker->name,
            'surname' => $this->faker->lastName(),
            'phone' => rand(53036473465, 5556874510),
            'email' => $this->faker->email(),
            'city' => $this->faker->city(),
            'source' => $this->faker->randomElement(['facebook', 'twitter', 'google', 'instagram', 'LinkedIn', 'Diğer', '']),
            'category' => $this->faker->sentence(1) . ' kategorisi',
            // 'status' => $this->faker->randomElement(['queued', 'positive', 'unanswered', 'busy']),
            // 'score' => random_int(1, 10),
            // 'note' => $this->faker->sentence(5),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
