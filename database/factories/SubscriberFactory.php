<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
class SubscriberFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'website_id' => fake()->numberBetween(0, 19),
        ];
    }
}
