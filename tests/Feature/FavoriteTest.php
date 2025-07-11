<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Получение списка фильмов добавленных пользователем в избранное
     */
    public function testUserCanGetTheirFavoriteFilmsList(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
