<?php

namespace Tests\Feature;

use App\Http\Resources\FilmResource;
use App\Models\Film;
use App\Models\User;
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
            'title' => 'Test Film',
            'description' => 'Test description',
        ]);

        $response->assertCreated()
            ->assertJsonStructure(['data']);
    }

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
            'title' => 'Updated Title',
        ]);

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

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

    /**
     * Тест получения текущего промо-фильма.
     *
     * @return void
     */
    public function testShowPromo(): void
    {
        $response = $this->getJson(route('promo.show'));

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    /**
     * Тест создания промо-фильма модератором.
     *
     * @return void
     */
    public function testCreatePromo(): void
    {
        $moderator = User::factory()->create([
            'role' => User::ROLE_MODERATOR,
        ]);
        $film = Film::factory()->create();

        $response = $this->actingAs($moderator)->postJson(route('promo.create', $film->id));

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    /**
     * Тест ошибки 401 при попытке добавить фильм неавторизованным пользователем.
     */
    public function testStoreFilmUnauthenticated(): void
    {
        $response = $this->postJson(route('films.store'), [
            'title' => 'Unauthorized Film',
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
            'title' => 'Not Allowed',
        ]);

        $response->assertForbidden();
    }

    /**
     * Тест ошибки 401 при попытке обновить фильм без авторизации.
     */
    public function testUpdateFilmUnauthenticated(): void
    {
        $film = Film::factory()->create();

        $response = $this->patchJson(route('films.update', $film->id), [
            'title' => 'No Access',
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
            'title' => 'Forbidden',
        ]);

        $response->assertForbidden();
    }

    /**
     * Тест ошибки 403 при попытке создать промо-фильм обычным пользователем.
     */
    public function testCreatePromoAsUser(): void
    {
        $user = User::factory()->create();
        $film = Film::factory()->create();

        $response = $this->actingAs($user)->postJson(route('promo.create', $film->id));

        $response->assertForbidden();
    }

    /**
     * Тест ошибки 401 при попытке создать промо-фильм без авторизации.
     */
    public function testCreatePromoUnauthenticated(): void
    {
        $film = Film::factory()->create();

        $response = $this->postJson(route('promo.create', $film->id));

        $response->assertUnauthorized();
    }

    /**
     * Тест создания промо для несуществующего фильма.
     */
    //    public function testCreatePromoNotFound(): void
    //    {
    //        $moderator = User::factory()->create([
    //            'role' => User::ROLE_MODERATOR,
    //        ]);
    //
    //        $response = $this->actingAs($moderator)->postJson(route('promo.create', 9999));
    //
    //        $response->assertNotFound()
    //            ->assertJson([
    //                'message' => 'Запрашиваемая страница не существует.',
    //            ]);
    //    } TODO дописать тест когда будет готов контроллер
}
