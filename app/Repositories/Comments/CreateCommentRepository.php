<?php

namespace App\Repositories\Comments;

use App\Models\Comment;

final class CreateCommentRepository
{
    public function create(array $data): Comment
    {
        return Comment::create($data);
    }
}
