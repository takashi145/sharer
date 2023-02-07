<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'url' => fake()->url(),
            'title' => fake()->word(),
            'description' => fake()->realText(200),
            'thumbnail_url' => fake()->imageUrl(
                $width = 640, 
                $height = 480,
                $category = 'cats', 
                $randomize = true, 
                $word = null
            )
        ];
    }
}
