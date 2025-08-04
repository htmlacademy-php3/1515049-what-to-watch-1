<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест выхода из системы аутентифицированного пользователя.
     * Ожидается статус 204 No Content.
     */
    public function testAuthenticatedUserCanLogout(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson(route('user.logout'));
        $response->assertStatus(204);
    }
}
