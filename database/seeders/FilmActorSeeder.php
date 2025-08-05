<?php

namespace Database\Seeders;

use App\Models\Actor;
use App\Models\Film;
use Illuminate\Database\Seeder;

/** @used-by DatabaseSeeder::run() */
final class FilmActorSeeder extends Seeder
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
        $actors = Actor::all();

        foreach ($films as $film) {
            $randomActors = collect((array) $actors->random(rand(1, 5)));
            $film->actors()->attach($randomActors->pluck('id')->all());
        }
    }
}
