<?php

namespace Database\Seeders;

use App\Models\FavoriteFilm;
use App\Models\Film;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FavoriteFilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $films = Film::all();

        foreach ($users as $user) {
            $user->favoriteFilms()->attach(
                $films->random(rand(1, 5))->pluck('id')->toArray()
            );
        }
    }
}
