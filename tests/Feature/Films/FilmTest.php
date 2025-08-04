<?php

namespace Tests\Feature\Films;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Тестирование функционала, связанного с фильмами.
 */
class FilmTest extends TestCase
{
    use RefreshDatabase;

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
