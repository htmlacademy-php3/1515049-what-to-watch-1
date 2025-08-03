<?php

namespace Tests\Feature\Films;

use App\Models\Film;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PromoFilmTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест получения текущего промо-фильма.
     *
     * @return void
     */
    public function testShowPromo(): void
    {
        $promoFilm = Film::factory()->create(['is_promo' => true]);
        $response = $this->getJson(route('promo.show'));

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $promoFilm->id,
                    'is_promo' => true
                ]
            ]);
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
}
