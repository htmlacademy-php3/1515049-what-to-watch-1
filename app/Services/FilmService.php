<?php

namespace App\Services;

use App\Models\Film;
use Illuminate\Contracts\Pagination\Paginator;

/**
 * Сервис для работы с фильмами.
 *
 * Предоставляет методы для получения списка фильмов с фильтрацией и
 * получения подробной информации о конкретном фильме.
 */
class FilmService
{
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
    public function getFilmList(array $filters = [], int $perPage = 8): Paginator
    {
        return Film::query()->with(
            ['genres', 'actors', 'directors']
        )->when(
            isset($filters['genre']),
            fn ($query) => $query->whereHas(
                'genres',
                fn ($query) => $query->where('name', $filters['genre'])
            )
        )->when(
            isset($filters['status']),
            fn ($query) => $query->where('status', $filters['status'])
        )->orderBy($filters['order_by'] ?? 'released', $filters['order_to'] ?? 'desc')->paginate($perPage);
    }

    /**
     *  Возвращает подробную информацию о фильме по его ID.
     *
     * @param int $id ID фильма
     *
     * @return Film Модель фильма со связями
     */
    public function getFilmDetails(int $id): Film
    {
        return Film::with(['genres', 'actors', 'directors'])->findOrFail($id);
    }
}
