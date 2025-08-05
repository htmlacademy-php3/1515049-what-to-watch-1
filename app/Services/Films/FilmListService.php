<?php

namespace App\Services\Films;

use App\Repositories\Films\FilmsListRepository;
use Illuminate\Contracts\Pagination\Paginator;

class FilmListService
{
    /**
     * @psalm-suppress PossiblyUnusedMethod
     * Laravel DI автоматически вызывает этот конструктор
     */
    public function __construct(
        protected FilmsListRepository $filmsListRepository,
        protected FavoriteFilmCheckService $favoriteFilmCheckService
    ) {
    }

    /**
     *  Возвращает список фильмов с поддержкой фильтрации и пагинации.
     *
     *  Доступные фильтры:
     *  - genre: фильтрация по жанру
     *  - status: фильтрация по статусу (только для модератора, по умолчанию ready)
     *  - order_by: поле сортировки (по умолчанию — released, дата выхода фильма; возможна
     *    сортировка по rating, рейтингу)
     *  - order_to: направление сортировки ('asc' или 'desc', по умолчанию 'desc')
     *
     * @param array $filters Массив фильтров
     * @param int   $perPage Количество фильмов на страницу
     *
     * @return Paginator Список фильмов с пагинацией
     */
    public function getFilmList(array $filters = [], ?int $userId = null, int $perPage = 8): Paginator
    {
        $films = $this->filmsListRepository->getFilms($filters, $perPage);

        if ($userId) {
            $films->getCollection()->transform(function ($film) use ($userId) {
                $film->is_favorite = $this->favoriteFilmCheckService->isFavorite($film->id, $userId);
                return $film;
            });
        }

        return $films;
    }
}
