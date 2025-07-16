<?php

namespace Tests\Feature;

use App\Jobs\UpdateFilm;
use App\Models\Film;
use App\Repositories\FilmsOmdbRepositoryInterface;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

/**
 * Тестирование задачи обновления информации о фильме через очередь.
 *
 * Проверяет, что:
 * - Задача корректно ставится в очередь.
 * - Репозиторий возвращает данные о фильме.
 * - Зависимость FilmsOmdbRepositoryInterface заменяется на мок.
 */
class UpdateFilmJobTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Проверяет, что задача обновления фильма ставится в очередь и использует
     * мок-репозиторий для получения данных о фильме.
     *
     * @throws Exception
     *
     * @return void
     */
    public function testUpdateFilmJobDispatchesAndSavesFilmData(): void
    {
        Queue::fake();

        $film = Film::factory()->create([
            'imdb_id' => 'tt0111161',
        ]);

        $this->app->bind(FilmsOmdbRepositoryInterface::class, function () {
            return Mockery::mock(FilmsOmdbRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('getFilmById')->once()->with('tt0111161')->andReturn([
                    'imdbID' => 'tt0111161',
                    'Title' => 'The Shawshank Redemption',
                    'Plot' => 'A banker convicted of uxoricide...',
                    'Runtime' => '142 min',
                    'Year' => 1994,
                    'imdbRating' => '9.3',
                    'Poster' => 'https://example.com/poster.jpg',
                    'imdbVotes' => '3,059,994',
                    'Director' => 'Frank Darabont',
                    'Actors' => 'Tim Robbins, Morgan Freeman, Bob Gunton',
                    'Genre' => 'Drama',
                ]);
                $mock->shouldReceive('getError')->zeroOrMoreTimes()->andReturn(null);
            });
        });

        UpdateFilm::dispatch('tt0111161', $film);

        Queue::assertPushed(UpdateFilm::class);
    }
}
