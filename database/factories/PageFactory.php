<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Page>
 */
class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'slug' => fake()->slug(),
            'title' => fake()->text(30),
            'content' => fake()->realText(),
            'seo' => [
                'title' => fake()->text(30),
                'description' => fake()->text(100),
                'image' => NULL,
            ],
            'status' => fake()->boolean(50)
        ];
    }
}
