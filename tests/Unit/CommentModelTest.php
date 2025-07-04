<?php

namespace Tests\Unit;

use AllowDynamicProperties;
use App\Models\Comment;
use App\Models\User;
use Faker\Factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

#[AllowDynamicProperties] class CommentModelTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function testAuthorName() : void
    {
        $this->faker = Factory::create('ru_RU');
        $user =
            User::factory()->create(['name' => 'Тестовый пользователь']);
        $userComment =
            Comment::factory()->for($user)->create();
        $guestComment =
            Comment::factory()->create(['user_id' => null]);

        $this->assertEquals('Тестовый пользователь', $userComment->getAuthorName());

        $this->assertEquals(Comment::DEFAULT_AUTHOR_NAME, $guestComment->getAuthorName());
    }
}
