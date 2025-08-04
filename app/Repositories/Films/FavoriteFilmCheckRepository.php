<?php

declare(strict_types=1);

namespace App\Repositories\Films;

use App\Models\FavoriteFilm;

/**
 * Репозиторий для проверки, добавлен ли фильм в избранное пользователем.
 *
 * Отвечает за обращение к таблице избранных фильмов (favorite_films)
 * и предоставляет метод для проверки наличия записи по ID пользователя и фильма.
 */
final class FavoriteFilmCheckRepository
{
    /**
     * Проверяет, добавлен ли фильм в избранное пользователем.
     *
     * @param int $filmId ID фильма
     * @param int $userId ID пользователя
     * @return bool true, если фильм в избранном; иначе false
     */
    public function isFavorite(int $filmId, int $userId): bool
    {
        return FavoriteFilm::where([
            'film_id' => $filmId,
            'user_id' => $userId
        ])->exists();
    }
}
