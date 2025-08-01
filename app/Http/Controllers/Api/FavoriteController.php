<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FilmResource;
use App\Http\Responses\SuccessResponse;
use App\Models\FavoriteFilm;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Список фильмов в избранном
     */
    public function index(Request $request): SuccessResponse
    {
        $userId = auth()->id();
        $perPage = 8;

        $favorites = FavoriteFilm::where('user_id', $userId)
            ->with(['film' => function ($query) {
                $query->with([
                    'genres:genres.id,genres.name',
                    'actors:actors.id,actors.name',
                    'directors:directors.id,directors.name',
                ]);
            }])
        ->orderBy('created_at', 'desc')
        ->paginate($perPage);

        $formatted = $favorites->map(function ($favorite) {
            $film = $favorite->film;
            $film->is_favorite = true;
            $film->added_at = $favorite->created_at->format('Y-m-d H:i:s');
            return new filmResource($film);
        });

        return $this->success([
            'data' => $formatted,
            'meta' => [
                'current_page' => $favorites->currentPage(),
                'per_page' => $favorites->perPage(),
                'total' => $favorites->total(),
                'last_page' => $favorites->lastPage(),
            ],
            'links' => $favorites->linkCollection()->toArray(),
        ]);
    }

    /**
     * Добавление фильма в избранное
     *
     * @param Request $request
     *
     * @return SuccessResponse
     */
    public function store(Request $request): SuccessResponse
    {
        return $this->success([]);
    }

    /**
     * Удаление из избранного
     *
     * @param Request $request
     *
     * @return SuccessResponse
     */
    public function destroy(Request $request): SuccessResponse
    {
        return $this->success([]);
    }
}
