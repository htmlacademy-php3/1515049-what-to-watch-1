<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FilmListResource;
use App\Http\Resources\FilmResource;
use App\Http\Responses\SuccessResponse;
use App\Services\FilmService;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    public function __construct(private readonly FilmService $filmService)
    {
    }

    /**
     * Список фильмов
     *
     * @param Request $request
     *
     * @return SuccessResponse
     */
    public function index(Request $request): SuccessResponse
    {
        $films =
            $this->filmService->getFilmList($request->all(), auth()->id());

        return $this->success(FilmListResource::collection($films));
    }

    /**
     * Просмотр страницы фильма
     *
     * @param int $id
     *
     * @return SuccessResponse
     */
    public function show(int $id): SuccessResponse
    {
        $film =
            $this->filmService->getFilmDetails($id);
        $film->is_favorite =
            auth()->check() && $this->filmService->isFavorite($id, auth()->id());

        return $this->success(new FilmResource($film));
    }

    /**
     * Добавление фильма в бд
     *
     * @param Request $request
     *
     * @return SuccessResponse
     * @throws \Throwable
     */
    public function store(Request $request): SuccessResponse
    {
        $film = $this->filmService->createFilm($request->all());

        return $this->success(new FilmResource($film));
    }

    /**
     * Обновление данных фильма
     *
     * @param Request $request
     * @param int     $id
     *
     * @return SuccessResponse
     * @throws \Throwable
     */
    public function update(Request $request, int $id): SuccessResponse
    {
        $film = $this->filmService->updateFilm($id, $request->all());
        return $this->success(new FilmResource($film));
    }

    /**
     * Список похожих фильмов
     *
     * @param int $id
     *
     * @return SuccessResponse
     */
    public function similar(int $id): SuccessResponse
    {
        return $this->success([]);
    }

    /**
     * Показ промо
     *
     * @return SuccessResponse
     */
    public function showPromo(): SuccessResponse
    {
        return $this->success([]);
    }

    /**
     * Создание промо
     *
     * @param Request $request
     * @param         $film_id
     *
     * @return SuccessResponse
     */
    public function createPromo(Request $request, $film_id): SuccessResponse
    {
        return $this->success([]);
    }
}
