<?php

namespace Tests\Feature\Comments;

use App\Models\Comment;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteCommentTest extends TestCase
{
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
     * Модератор может удалить любой комментарий
     *
     * @return void
     */
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
