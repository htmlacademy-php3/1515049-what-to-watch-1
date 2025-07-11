<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessResponse;
use App\Models\Comment;
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
    public function index(int $film_id) : SuccessResponse
    {
        return $this->success([]);
    }

    /**
     * Добавление комментария
     *
     * @param Request $request
     * @param int     $film_id
     *
     * @return SuccessResponse
     */
    public function store(Request $request, int $film_id) : SuccessResponse
    {
        return $this->success([]);
    }

    /**
     * Изменение комментария
     *
     * @param Request $request
     * @param Comment $comment
     *
     * @return SuccessResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, Comment $comment) : SuccessResponse
    {
        Gate::authorize('update-comment', $comment);
        return $this->success([]);
    }

    /**
     * Удаление комментария
     *
     * @param string $comment
     *
     * @return SuccessResponse
     * @throws AuthorizationException
     */
    public function destroy(string $comment) : SuccessResponse
    {
        Gate::authorize('delete-comment', $comment);
        return $this->success([]);
    }
}
