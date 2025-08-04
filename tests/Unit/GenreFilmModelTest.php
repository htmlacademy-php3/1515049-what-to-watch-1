<?php

namespace Tests\Unit;

use App\Models\Film;
use App\Models\Genre;
use App\Models\GenreFilm;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Тесты модели GenreFilm.
 */
class GenreFilmModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Проверяет, что GenreFilm принадлежит фильму.
     */
    public function testGenreFilmBelongsToFilm(): void
    {
        $film = Film::factory()->create();
        $genre = Genre::factory()->create();

        $genreFilm = GenreFilm::create([
            'film_id' => $film->id,
            'genre_id' => $genre->id,
        ]);

        $this->assertInstanceOf(Film::class, $genreFilm->film);
    }

    /**
     * Проверяет, что GenreFilm принадлежит жанру.
     */
    public function testGenreFilmBelongsToGenre(): void
    {
        $film = Film::factory()->create();
        $genre = Genre::factory()->create();

        $genreFilm = GenreFilm::create([
            'film_id' => $film->id,
            'genre_id' => $genre->id,
        ]);

        $this->assertInstanceOf(Genre::class, $genreFilm->genre);
    }
}
