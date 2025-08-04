<?php

namespace App\Services\Comments;

use App\Models\Comment;
use App\Repositories\Comments\CommentsFetchRepository;
use Illuminate\Support\Collection;

/**
 * Сервис получения всех комментариев к фильму
 */
class CommentsFetchService
{


    /**
     * Получение комментариев к фильму
     *
     * @psalm-return Collection<Comment, array{text: string, author: string, created_at: string, rate: int|null}>|\Illuminate\Database\Eloquent\Collection<Comment, array{text: string, author: string, created_at: string, rate: int|null}>
     */
    public function getFilmComments(int $filmId): Collection|\Illuminate\Database\Eloquent\Collection
    {
        return $this->commentsFetchRepository->getComments($filmId)
            ->map(function (Comment $comment) {
                return [
                    'text' => $comment->text,
                    'author' => $comment->user?->name ?? 'Гость',
                    'created_at' => $comment->created_at->toDateTimeString(),
                    'rate' => $comment->rate,
                ];
            });
    }
}
