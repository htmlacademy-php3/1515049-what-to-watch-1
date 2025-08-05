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
        $moderator =
            User::factory()->create([
                'role' => User::ROLE_MODERATOR,
            ]);

        $response =
            $this->actingAs($moderator)->postJson(route('films.store'), [
                'imdb_id' => 'tt1234567',
            ]);

        $response->assertCreated()->assertJsonStructure([
                'data' => [
                    "id",
                    "name",
                    "poster_image",
                    "preview_image",
                    "background_image",
                    "background_color",
                    "video_link",
                    "preview_video_link",
                    "description",
                    "rating",
                    "scores_count",
                    "director",
                    "starring",
                    "run_time",
                    "genre",
                    "released",
                    "is_favorite",
                    "is_promo",
                ]
            ]);
    }

    /**
     * Тест ошибки 401 при попытке добавить фильм неавторизованным пользователем.
     */
    public function testStoreFilmUnauthenticated(): void
    {
        $response =
            $this->postJson(route('films.store'), [
                'imdb_id' => 'tt1234567',
            ]);

        $response->assertUnauthorized()->assertJson([
                'message' => 'Запрос требует аутентификации.',
            ]);
    }

    /**
     * Тест ошибки 403 при попытке добавить фильм обычным пользователем.
     */
    public function testStoreFilmAsUser(): void
    {
        $user =
            User::factory()->create();

        $response =
            $this->actingAs($user)->postJson(route('films.store'), [
                'imdb_id' => 'tt1234567',
            ]);

        $response->assertForbidden();
    }

}
