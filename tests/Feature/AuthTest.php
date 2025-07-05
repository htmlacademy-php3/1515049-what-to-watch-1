<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testUserCanRegisterSuccessfully(): void
    {
        $response =
            $this->postJson(route('user.register'), [
                'name' => 'Test User',
                'email' => 'test@example.ru',
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', ['email' => 'test@example.ru']);
    }

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

    public function testAuthenticatedUserCanLogout(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson(route('user.logout'));
        $response->assertStatus(204);
    }
}
