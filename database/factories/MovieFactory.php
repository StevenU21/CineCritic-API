<?php

namespace Database\Factories;

use App\Models\Director;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->sentence(6),
            'cover_image' => fake()->imageUrl(),
            'release_date' => fake()->date('Y-m-d'),
            'trailer_url' => fake()->url(),
            'duration' => fake()->randomElement([90, 120, 150, 180]),
            'director_id' => Director::inRandomOrder()->first()->id,
            'genre_id' => Genre::inRandomOrder()->first()->id,
        ];
    }
}
