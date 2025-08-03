<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Тест успешной регистрации пользователя.
     * Ожидается статус 201 и наличие пользователя в БД.
     */
    public function testUserCanRegisterSuccessfully(): void
    {
        $response =
            $this->postJson(route('user.register'), [
                'name' => 'Test User',
                'email' => 'test@example.ru',
                'password' => 'Password!2',
                'password_confirmation' => 'Password!2',
            ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', ['email' => 'test@example.ru']);
    }
}
