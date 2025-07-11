<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessResponse;
use App\Models\FavoriteFilm;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Список фильмов в избранном
     *
     * @param Request $request
     *
     * @return SuccessResponse
     */
    public function index(Request $request): SuccessResponse
    {
        $userId = auth()->id();
        $perPage = 8;

        $query = FavoriteFilm::where('user_id', $userId)
            ->with(['film' => function ($query) {
                $query->with([
                    'genres:genres.id,genres.name',
                    'actors:actors.id,actors.name',
                    'directors:directors.id,directors.name'
                ])->select([
                    'id',
                    'name',
                    'poster_image',
                    'preview_image',
                    'background_image',
                    'background_color',
                    'video_link',
                    'preview_video_link',
                    'description',
                    'rating',
//                    'scores_count',
                    'run_time',
                    'released'
                ]);
            }])
            ->orderBy('created_at', 'desc');

        $favorites = $query->paginate($perPage);

        $formatted = $favorites->map(function ($favorite) {
            return [
                'id' => $favorite->film->id,
                'name' => $favorite->film->name,
                'poster_image' => $favorite->film->poster_image,
                'preview_image' => $favorite->film->preview_image,
                'background_image' => $favorite->film->background_image,
                'background_color' => $favorite->film->background_color,
                'video_link' => $favorite->film->video_link,
                'preview_video_link' => $favorite->film->preview_video_link,
                'description' => $favorite->film->description,
                'rating' => $favorite->film->rating,
//                'scores_count' => $favorite->film->scores_count, TODO добавить это
                'director' => $favorite->film->directors->first()->name ?? null,
                'starring' => $favorite->film->actors->pluck('name')->toArray(),
                'run_time' => $favorite->film->run_time,
                'genre' => $favorite->film->genres->pluck('name')->first(),
                'released' => $favorite->film->released,
                'is_favorite' => true,
                'added_at' => $favorite->created_at->format('Y-m-d H:i:s')
            ];
        });

        return $this->success([
            'data' => $formatted,
            'meta' => $favorites->only(['current_page', 'per_page', 'total', 'last_page']),
            'links' => $favorites->linkCollection()->toArray()
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
