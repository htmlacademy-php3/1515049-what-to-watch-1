<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Film;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $films = Film::all();

            Comment::factory(10)->make()->each(function ($comment) use ($users,  $films) {
                $comment->user_id = $users->random()->id;
                $comment->film_id = $films->random()->id;
                $comment->save();
            });

    }
}
