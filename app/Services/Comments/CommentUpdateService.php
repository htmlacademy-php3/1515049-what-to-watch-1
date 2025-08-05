<?php

namespace App\Services\Comments;

use App\Models\Comment;
use App\Repositories\Comments\UpdateCommentRepository;

/**
 * Сервис редактирования комментария к фильму
 */
class CommentUpdateService
{
    /**
     * @psalm-suppress PossiblyUnusedMethod
     * Laravel DI автоматически вызывает этот конструктор
     */
    public function __construct(protected UpdateCommentRepository $updateCommentRepository)
    {

    }

    /**
     * Обновление комментария
     */
    public function updateComment(Comment $comment, array $data): Comment
    {

        return $this->updateCommentRepository->update($comment, $data);
    }
}
