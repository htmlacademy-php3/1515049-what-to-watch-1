<?php

namespace App\Services\Comments;

use App\Models\Comment;

class CommentDeleteService
{
    /**
     * Удаление комментария с ответами
     */
    public function deleteComment(Comment $comment): void
    {
        $comment->deleteWithReplies();
    }
}
