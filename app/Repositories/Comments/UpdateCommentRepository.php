<?php

namespace App\Repositories\Comments;

final class UpdateCommentRepository
{
    public function update($comment, array $data)
    {
        $comment->update($data);
        return $comment->fresh();
    }
}
