<?php

namespace Tests\Feature\Films;

use App\Models\Film;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SimilarFilmTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест получения списка похожих фильмов.
     *
     * @return void
     */
    public function testSimilarFilms(): void
    {
        $film = Film::factory()->create();

        $response = $this->getJson(route('films.similar', $film->id));

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }
}
