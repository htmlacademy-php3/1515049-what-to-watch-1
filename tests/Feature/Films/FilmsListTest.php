<?php

namespace Tests\Feature\Films;

use App\Models\Film;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilmsListTest extends TestCase
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
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'poster_image',
                        'preview_image',
                        'preview_video_link',
                        'genre',
                        'released'
                    ]
                ]
            ])
            ->assertJsonCount(8, 'data');
    }

}
