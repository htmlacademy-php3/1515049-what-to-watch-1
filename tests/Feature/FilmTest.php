<?php

namespace Tests\Feature;

use App\Http\Resources\FilmResource;
use App\Models\Film;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FilmTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
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

    public function testReturnsFilmDetails(): void
    {
        $film = Film::factory()->create();

        $response = $this->getJson(route('films.show', $film->id));

        $response->assertOk()
            ->assertJson([
                'data' => new FilmResource($film)->response()->getData(true)['data'],
            ]);
    }

    public function testReturns404WhenFilmNotFound(): void
    {
        $response = $this->getJson(route('films.show', ['id' => 999]));

        $response->assertNotFound()
        ->assertJson([
            'message' => 'Запрашиваемая страница не существует.',
        ]);
    }
}
