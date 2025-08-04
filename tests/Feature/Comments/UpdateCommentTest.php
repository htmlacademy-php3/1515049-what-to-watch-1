<?php

namespace Tests\Feature\Comments;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateCommentTest extends TestCase
{
    use RefreshDatabase;

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

}
