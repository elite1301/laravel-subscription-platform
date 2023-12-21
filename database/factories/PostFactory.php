<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'website_id' => fake()->numberBetween(0, 19),
            'title' => fake()->realText(),
            'slug' => fake()->unique()->slug(),
            'content' => fake()->sentence(200),
        ];
    }
}
