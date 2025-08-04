<?php

namespace Tests\Feature\Comments;

use App\Models\Comment;
use App\Models\Film;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentsFetchTest extends TestCase
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
}
