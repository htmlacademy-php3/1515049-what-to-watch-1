<?php

namespace Database\Factories;

use App\Models\Film;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Film>
 */
class FilmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'year' => $this->faker->year,
            'description' => $this->faker->paragraph,
            'duration' => $this->faker->numberBetween(80, 180),
            'imdb_rating' => $this->faker->randomFloat(1, 4, 10),
            'imdb_votes' => $this->faker->numberBetween(1000, 10000),
            'imdb_id' => $this->faker->unique()->regexify('tt[0-9]{7}'),
            'poster_url' => $this->faker->imageUrl(),
            'preview_url' => $this->faker->imageUrl(),
            'background_color' => $this->faker->hexColor,
            'cover_url' => $this->faker->imageUrl(),
            'video_url' => $this->faker->url(),
            'video_preview_url' => $this->faker->url(),
        ];
    }
}
