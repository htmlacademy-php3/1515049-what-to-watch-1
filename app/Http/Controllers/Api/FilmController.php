<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FilmListResource;
use App\Http\Resources\FilmResource;
use App\Http\Responses\SuccessResponse;
use App\Models\Film;
use App\Services\FilmService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

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
        $this->setFavoriteFlag($film);

        return $this->success(new FilmResource($film));
    }

    /**
     * Устанавливает флаг "избранного" для переданного фильма,
     * если пользователь авторизован и добавил фильм в избранное.
     *
     * @param Film $film
     *
     * @return void
     */
    protected function setFavoriteFlag(Film $film): void
    {
        $film->is_favorite = auth()->check()
            && $this->filmService->isFavorite($film->id, auth()->id());
    }

    /**
     * Добавление фильма в бд
     *
     * @param Request $request
     *
     * @return SuccessResponse
     * @throws Throwable
     */
    public function store(Request $request): SuccessResponse
    {
        $film = $this->filmService->createFilm($request->all());

        return $this->success(new FilmResource($film), Response::HTTP_CREATED);
    }

    /**
     * Обновление данных фильма
     *
     * @param Request $request
     * @param int     $id
     *
     * @return SuccessResponse
     * @throws Throwable
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
        $films = $this->filmService->getSimilarFilms($id, auth()->id());
        return $this->success(FilmListResource::collection($films));
    }

    /**
     * Показ промо
     *
     * @return SuccessResponse
     */
    public function showPromo(): SuccessResponse
    {
        $film = $this->filmService->getPromoFilm();
        $this->setFavoriteFlag($film);

        return $this->success(new FilmResource($film));
    }

    /**
     * Создание промо
     *
     * @param Request $request
     * @param         $filmId
     *
     * @return SuccessResponse
     * @throws Throwable
     */
    public function createPromo(Request $request, $filmId): SuccessResponse
    {
        $film = $this->filmService->setPromoFilm($filmId);

        return $this->success(new FilmResource($film));
    }
}
