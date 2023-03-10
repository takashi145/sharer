<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
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
            'user_id' => User::factory(),
            'category_id' => rand(1, 13),
            'title2' => fake()->word(),
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
