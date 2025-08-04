<?php

namespace Tests\Feature\Films;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilmCreateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест успешного добавления фильма модератором.
     *
     * @return void
     */
    public function testStoreFilm(): void
    {
        $moderator = User::factory()->create([
            'role' => User::ROLE_MODERATOR,
        ]);

        $response = $this->actingAs($moderator)->postJson(route('films.store'), [
            'name' => 'Test Film',
            'description' => 'Test description',
        ]);

        $response->assertCreated()
            ->assertJsonStructure(['data']);
    }

    /**
     * Тест ошибки 401 при попытке добавить фильм неавторизованным пользователем.
     */
    public function testStoreFilmUnauthenticated(): void
    {
        $response = $this->postJson(route('films.store'), [
            'name' => 'Unauthorized Film',
        ]);

        $response->assertUnauthorized()
            ->assertJson([
                'message' => 'Запрос требует аутентификации.',
            ]);
    }

    /**
     * Тест ошибки 403 при попытке добавить фильм обычным пользователем.
     */
    public function testStoreFilmAsUser(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('films.store'), [
            'name' => 'Not Allowed',
        ]);

        $response->assertForbidden();
    }

}
