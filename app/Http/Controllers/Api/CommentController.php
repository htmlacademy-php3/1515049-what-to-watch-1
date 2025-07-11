<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Responses\SuccessResponse;
use App\Models\Comment;
use App\Models\Film;
use Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    /**
     * Список комментариев к фильму
     *
     * @param int $film_id
     *
     * @return SuccessResponse
     */
    public function index(int $film_id): SuccessResponse
    {
        $comments = Comment::with('user')
            ->where('film_id', $film_id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($comment) {
                return [
                    'text' => $comment->text,
                    'author' => $comment->user?->name ?? 'Гость',
                    'created_at' => $comment->created_at->toDateTimeString(),
                    'rate' => $comment->rate,
                ];
            });
        return $this->success($comments, 201);
    }

    /**
     * Добавление комментария
     *
     * @param StoreCommentRequest $request
     * @param                     $filmId
     *
     * @return SuccessResponse
     */
    public function store(StoreCommentRequest $request, $filmId): SuccessResponse
    {
        $comment = Comment::create([
            'user_id' => auth()->id(),
            'film_id' => $filmId,
            'text' => $request->text,
            'rate' => $request->rate,
        ]);

        return $this->success($comment, 201);
    }

    /**
     * Редактирование комментария
     *
     * @param UpdateCommentRequest $request
     * @param Comment              $comment
     *
     * @return SuccessResponse
     * @throws AuthorizationException
     */
    public function update(UpdateCommentRequest $request, Comment $comment): SuccessResponse
    {
        Gate::authorize('update-comment', $comment);
        $comment->update($request->validated());
        return $this->success([
            'text' => $comment->text,
            'rate' => $comment->rate,
        ], 200);
    }

    /**
     * Удаление комментария
     *
     * @param Comment $comment
     *
     * @return SuccessResponse
     * @throws AuthorizationException
     */
    public function destroy(Comment $comment): SuccessResponse
    {
        Gate::authorize('delete-comment', $comment);
        $comment -> delete();
        return $this->success([]);
    }
}
