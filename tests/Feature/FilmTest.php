<?php

namespace Tests\Feature;

use App\Http\Resources\FilmResource;
use App\Models\Film;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Тестирование функционала, связанного с фильмами.
 */
class FilmTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тестирование получения списка фильмов с пагинацией.
     *
     *  Проверяет:
     *  - Успешный статус ответа (200 OK)
     *  - Корректную структуру JSON-ответа
     *  - Количество элементов на странице (по умолчанию 8)
     *  - Наличие данных о пагинации
     *
     * @return void
     */
    public function testReturnsPaginatedFilmList(): void
    {
        Film::factory()->count(20)->create();

        $response = $this->getJson(route('films.index'));

        $response->assertOk()
            ->assertJsonStructure([
                'data',
                'current_page',
                'first_page_url',
                'next_page_url',
                'prev_page_url',
                'per_page',
                'total'
            ])
        ->assertJsonCount(8, 'data');
    }

    /**
     * Тестирование получения детальной информации о фильме.
     *
     *  Проверяет:
     *  - Успешный статус ответа (200 OK)
     *  - Корректность возвращаемых данных
     *  - Корректную структуру JSON-ответа
     *
     * @return void
     */
    public function testReturnsFilmDetails(): void
    {
        $film = Film::factory()->create();

        $response = $this->getJson(route('films.show', $film->id));

        $response->assertOk()
            ->assertJson([
                'data' => new FilmResource($film)->response()->getData(true)['data'],
            ]);
    }

    /**
     * Тестирование обработки случая, когда фильм не найден.
     *
     *  Проверяет:
     *  - Статус ответа 404 Not Found
     *  - Наличие корректного сообщения об ошибке
     *  - Формат JSON-ответа
     *
     * @return void
     */
    public function testReturns404WhenFilmNotFound(): void
    {
        $response = $this->getJson(route('films.show', ['id' => 999]));

        $response->assertNotFound()
        ->assertJson([
            'message' => 'Запрашиваемая страница не существует.',
        ]);
    }
}
