<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run() : void
    {
        $this->call([
            UserSeeder::class,
            FilmSeeder::class,
            GenreSeeder::class,
            ActorSeeder::class,
            DirectorSeeder::class,
            CommentSeeder::class,
            FavoriteFilmSeeder::class,
            FilmActorSeeder::class,
            FilmDirectorSeeder::class,
            FilmGenreSeeder::class,
            ]);
    }
}
