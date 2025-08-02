<?php

namespace App\Repositories\Comments;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

final class CommentsFetchRepository
{
    public function getComments(int $filmId): Collection
    {
        return Comment::with('user')
            ->where('film_id', $filmId)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
