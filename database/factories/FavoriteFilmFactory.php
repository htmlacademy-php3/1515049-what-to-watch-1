<?php

namespace Database\Factories;

use App\Models\FavoriteFilm;
use App\Models\Film;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FavoriteFilm>
 */
class FavoriteFilmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return Factory[]
     *
     * @psalm-return array{user_id: Factory, film_id: Factory}
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'film_id' => Film::factory(),
        ];
    }
}
