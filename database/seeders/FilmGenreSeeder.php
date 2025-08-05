<?php

namespace Database\Seeders;

use App\Models\Film;
use App\Models\Genre;
use Illuminate\Database\Seeder;

/** @used-by DatabaseSeeder::run() */
final class FilmGenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @psalm-suppress PossiblyUnusedMethod
     *  Вызывается системой Laravel при выполнении artisan db:seed
     */
    public function run(): void
    {
        $films = Film::all();
        $genres = Genre::all();

        foreach ($films as $film) {
            $randomGenres = collect((array) $genres->random(rand(1, 2)));
            $film->genres()->attach($randomGenres->pluck('id')->all());
        }
    }
}
