<?php

namespace App\Repositories\Comments;

use App\Models\Comment;

/**
 * Репозиторий для обновления комментариев.
 */
final class UpdateCommentRepository
{
    /**
     * Обновляет указанный комментарий новыми данными.
     *
     * @param Comment $comment Объект комментария для обновления
     * @param array   $data    Данные для обновления (например: text, rate)
     *
     * @return Comment Обновлённый и перезагруженный комментарий
     */
    public function update(Comment $comment, array $data): Comment
    {
        $comment->update($data);
        return $comment->fresh();
    }
}
