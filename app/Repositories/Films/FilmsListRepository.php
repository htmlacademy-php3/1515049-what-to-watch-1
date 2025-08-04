<?php

namespace App\Repositories\Films;

use App\Models\Film;
use Illuminate\Contracts\Pagination\Paginator;

/**
 * Репозиторий получения списка фильмов
 */
final class FilmsListRepository
{
    /**
     * Получение списка фильмов с фильтрацией и пагинацией.
     */
    public function getFilms(array $filters = [], int $perPage = 8): Paginator
    {
        return Film::query()
            ->with(['genres', 'actors', 'directors'])
            ->when(
                isset($filters['genre']),
                fn ($query) => $query->whereHas(
                    'genres',
                    fn ($query) => $query->where('name', $filters['genre'])
                )
            )
            ->when(
                isset($filters['status']),
                fn ($query) => $query->where('status', $filters['status'])
            )
            ->orderBy($filters['order_by'] ?? 'released', $filters['order_to'] ?? 'desc')
            ->paginate($perPage);
    }
}
