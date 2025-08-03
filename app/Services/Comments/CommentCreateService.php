<?php

namespace App\Services\Comments;

use App\Models\Comment;
use App\Repositories\Comments\CreateCommentRepository;

/**
 * Сервис создания комментария к фильму
 */
class CommentCreateService
{
    public function __construct(protected CreateCommentRepository $createCommentRepository)
    {
    }

    /**
     * Создание нового комментария
     */
    public function createComment(array $data): Comment
    {
        return $this->createCommentRepository->create($data);
    }
}
