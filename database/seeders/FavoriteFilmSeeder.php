<?php

namespace Database\Seeders;

use App\Models\FavoriteFilm;
use App\Models\Film;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/** @used-by DatabaseSeeder::run() */
final class FavoriteFilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @psalm-suppress PossiblyUnusedMethod
     *  Вызывается системой Laravel при выполнении artisan db:seed
     */
    public function run(): void
    {
        $users = User::all();
        $films = Film::all();

        foreach ($users as $user) {
            $randomFavoriteFilms = collect((array) $films->random(rand(1, 5)));
            $user->favoriteFilms()->attach($randomFavoriteFilms->pluck('id')->all());
        }
    }
}
