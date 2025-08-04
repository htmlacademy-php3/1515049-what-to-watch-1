<?php

namespace App\Repositories\Comments;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

/**
 * Репозиторий для получения комментариев к фильмам.
 */
final class CommentsFetchRepository
{
    /**
     * Получает список комментариев к фильму с загруженными пользователями.
     *
     * @param int $filmId ID фильма
     *
     * @return Collection Коллекция комментариев с отношением user
     *
     * @psalm-return Collection<int, Comment>
     */
    public function getComments(int $filmId): Collection
    {
        return Comment::with('user')
            ->where('film_id', $filmId)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
