<?php

namespace Tests\Feature\Films;

use App\Http\Resources\FilmResource;
use App\Models\Film;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilmDetailsTest extends TestCase
{
    use RefreshDatabase;

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

}
