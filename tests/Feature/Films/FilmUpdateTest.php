<?php

namespace Tests\Feature\Films;

use App\Models\Film;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilmUpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест успешного обновления фильма модератором.
     *
     * @return void
     */
    public function testUpdateFilm(): void
    {
        $moderator = User::factory()->create([
            'role' => User::ROLE_MODERATOR,
        ]);
        $film = Film::factory()->create();

        $response = $this->actingAs($moderator)->patchJson(route('films.update', $film->id), [
            'name' => 'Updated Title',
        ]);

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    /**
     * Тест ошибки 401 при попытке обновить фильм без авторизации.
     */
    public function testUpdateFilmUnauthenticated(): void
    {
        $film = Film::factory()->create();

        $response = $this->patchJson(route('films.update', $film->id), [
            'name' => 'No Access',
        ]);

        $response->assertUnauthorized();
    }

    /**
     * Тест ошибки 403 при попытке обновить фильм обычным пользователем.
     */
    public function testUpdateFilmAsUser(): void
    {
        $user = User::factory()->create();
        $film = Film::factory()->create();

        $response = $this->actingAs($user)->patchJson(route('films.update', $film->id), [
            'name' => 'Forbidden',
        ]);

        $response->assertForbidden();
    }
}
