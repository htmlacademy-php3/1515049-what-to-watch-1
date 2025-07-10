<?php

namespace Tests\Unit;

use App\Models\Film;
use App\Models\Genre;
use App\Services\FilmService;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\TestCase;

#[CoversClass(FilmService::class)] class FilmServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Сервис получения фильмов
     *
     * @var FilmService|Application|mixed|object
     */
    protected FilmService $filmService;

    /**
     * Устанавливает окружение перед каждым тестом
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->filmService = app(FilmService::class);
    }

    /**
     * Метод getFilms возвращает список фильмов с пагинацией
     *
     * @return void
     */
    public function testIsReturnsPaginatedFilmList(): void
    {
        Film::factory()->count(50)->create();

        $result = $this->filmService->getFilmList();

        $this->assertEquals(8, $result->items());
        $this->assertEquals(50, $result->total());
    }

    /**
     * Фильтрация фильмов по жанру
     *
     * @return void
     */
    public function testFilteredFilmListByGenre(): void
    {
        $genre = Genre::factory()->create(['name' => 'Comedy']);
        $filmWithGenre = Film::factory()->hasAttached($genre)->create();
        Film::factory()->create();

        $result = $this->filmService->getFilmList(['genre' => 'Comedy']);

        $this->assertCount(1, $result->items());
        $this->assertTrue($result->items()[0]->is($filmWithGenre));
    }

    /**
     * Получение информации по фильму
     *
     * @return void
     */
    public function testReturnFilmDetails(): void
    {
        $films = Film::factory()->create();
        $film = $this->filmService->getFilmDetails($films->id);

        $this->assertEquals($films->id, $film->id);
    }
}
