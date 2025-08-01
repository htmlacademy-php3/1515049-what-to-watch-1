<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Film;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * Функциональные тесты для работы с комментариями:
 * - просмотр комментариев к фильму;
 * - добавление, редактирование и удаление комментариев;
 * - редактирование и удаление чужих комментариев только модератором
 */
class CommentsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Получение комментариев к фильму
     *
     * @return void
     */
    public function testUserCanViewCommentsForFilm(): void
    {
        $film =
            Film::factory()->create();
        Comment::factory()->count(3)->create(['film_id' => $film->id]);

        $response =
            $this->getJson(route('comments.index', ['id' => $film->id]));
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['text', 'author', 'created_at', 'rate']
            ]
        ]);
    }

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

    /**
     * Редактирование своего комментария
     */
    public function testUserCanEditCommentsForFilm(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
        ]);

        $newText = 'Test comment Test comment Test comment Test comment Test comment';

        $response = $this->patchJson(route('comments.update', ['comment' => $comment->id]), [
            'text' => $newText,
            'rate' => 5,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'user_id' => $user->id,
            'text' => $newText,
            'rate' => 5,
        ]);
    }

    /**
     * Удаление своего комментария
     */
    public function testUserCanDeleteCommentsForFilm(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->deleteJson(route('comments.destroy', ['comment' => $comment->id]));

        $response->assertStatus(204);
        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
        ]);
    }

    /**
     * Пользователь не может редактировать чужой комментарий
     *
     * @return void
     */
    public function testUserCannotUpdateOthersComments(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $anotherUser = User::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $anotherUser->id,
        ]);

        $newText = 'Test comment Test comment Test comment Test comment';

        $response = $this->patchJson(route('comments.update', ['comment' => $comment->id]), [
            'text' => $newText,
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'user_id' => $anotherUser->id,
            'text' => $comment->text,
            'rate' => $comment->rate,
        ]);
    }

    /**
     * Пользователь не может удалить чужой комментарий
     *
     * @return void
     */
    public function testUserCannotDeleteOthersComments(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $anotherUser = User::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $anotherUser->id,
        ]);

        $response = $this->deleteJson(route('comments.destroy', ['comment' => $comment->id]));

        $response->assertStatus(403);
        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'user_id' => $anotherUser->id,
            'text' => $comment->text,
            'rate' => $comment->rate,
        ]);
    }

    /**
     * Модератор может редактировать любые комментарии
     *
     * @return void
     */
    public function testModeratorCanUpdateOthersComments(): void
    {
        $moderator = User::factory()->create([
            'role' => User::ROLE_MODERATOR,
        ]);
        Sanctum::actingAs($moderator);

        $anotherUser = User::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $anotherUser->id,
        ]);

        $newText = 'Test comment moderator Test comment Test comment Test comment';

        $response = $this->patchJson(route('comments.update', ['comment' => $comment->id]), [
            'text' => $newText,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'user_id' => $anotherUser->id,
            'text' => $newText,
            'rate' => $comment->rate,
        ]);
    }

    public function testModeratorCanDeleteOthersComments(): void
    {
        $moderator = User::factory()->create([
            'role' => User::ROLE_MODERATOR,
        ]);
        Sanctum::actingAs($moderator);
        $anotherUser = User::factory()->create();

        $comment = Comment::factory()->create([
            'user_id' => $anotherUser->id,
        ]);

        $response = $this->deleteJson(route('comments.destroy', ['comment' => $comment->id]));

        $response->assertStatus(204);
        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
        ]);
    }
}
