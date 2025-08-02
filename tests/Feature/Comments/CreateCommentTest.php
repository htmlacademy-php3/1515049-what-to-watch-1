<?php

namespace Tests\Feature\Comments;

use App\Models\Film;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateCommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Добавление комментария к фильму.
     *
     * @return void
     */
    public function testUserCanAddCommentsForFilm(): void
    {
        $user =
            User::factory()->create();
        Sanctum::actingAs($user);

        $film =
            Film::factory()->create();
        $commentData = [
            'text' => 'Test comment Test comment Test comment Test comment Test comment ',
            'rate' => 8,
        ];
        $response =
            $this->postJson(
                route('comments.store', ['id' => $film->id]),
                $commentData
            );

        $response->assertStatus(201);
        $this->assertDatabaseHas('comments', [
            'film_id' => $film->id,
            'user_id' => $user->id,
            'text' => 'Test comment Test comment Test comment Test comment Test comment ',
            'rate' => 8,
        ]);
    }
}
