<?php

namespace Database\Seeders;

use App\Models\Director;
use App\Models\Film;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/** @used-by DatabaseSeeder::run() */
final class FilmDirectorSeeder extends Seeder
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
        $directors = Director::all();

        foreach ($films as $film) {
            $randomDirectors = collect((array) $directors->random(1));
            $film->directors()->attach($randomDirectors->pluck('id')->all());
        }
    }
}
