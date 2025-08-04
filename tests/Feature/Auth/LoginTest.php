<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест успешного входа с корректными данными.
     * Ожидается статус 200 и наличие токена в ответе.
     */
    public function testUserCanLoginWithCorrectCredentials(): void
    {
        User::factory()->create([
            'email' => 'test@example.ru',
            'password' => Hash::make('password'),
        ]);

        $response =
            $this->postJson(route('user.login'), [
                'email' => 'test@example.ru',
                'password' => 'password',
            ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'token',
            ]
        ]);
    }

    /**
     * Тест неудачного входа с неверным паролем.
     * Ожидается статус 401 Unauthorized.
     */
    public function testUserCannotLoginWithWrongPassword(): void
    {
        User::factory()->create([
            'email' => 'test@example.ru',
            'password' => Hash::make('password'),
        ]);

        $response =
            $this->postJson(route('user.login'), [
                'email' => 'test@example.ru',
                'password' => 'wrongPassword',
            ]);

        $response->assertStatus(401);
    }
}
