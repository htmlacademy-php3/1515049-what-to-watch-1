<?php

namespace App\Services\Comments;

use App\Models\Comment;
use App\Repositories\Comments\UpdateCommentRepository;

class CommentUpdateService
{
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
