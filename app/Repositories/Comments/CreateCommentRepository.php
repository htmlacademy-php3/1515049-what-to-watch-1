<?php

namespace App\Repositories\Comments;

use App\Models\Comment;

/**
 * Репозиторий для создания комментариев.
 */
final class CreateCommentRepository
{
    /**
     * Создаёт новый комментарий.
     *
     * @param array $data Ассоциативный массив данных комментария (text, rate, user_id, film_id и т.д.)
     * @return Comment Созданная модель комментария
     */
    public function create(array $data): Comment
    {
        return Comment::create($data);
    }
}
