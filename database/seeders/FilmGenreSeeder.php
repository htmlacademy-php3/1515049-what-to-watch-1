<?php

namespace Database\Seeders;

use App\Models\Film;
use App\Models\Genre;
use Illuminate\Database\Seeder;

class FilmGenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $films = Film::all();
        $genres = Genre::all();

        foreach ($films as $film) {
            $film->genres()->attach($genres->random(rand(1,2))->pluck('id')->toArray());
        }
    }
}
