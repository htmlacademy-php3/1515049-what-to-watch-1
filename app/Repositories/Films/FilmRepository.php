<?php

namespace App\Repositories\Films;

use App\Models\Film;
use Illuminate\Database\Eloquent\Collection;

/**
 * Репозиторий для фильмов
 */
final class FilmRepository
{
    /**
     * Создает фильм
     *
     * @param array $data
     * @return Film
     */
    public function create(array $data): Film
    {
        return Film::create($data);
    }

    /**
     * Обновляет данные фильма
     *
     * @param Film  $film
     * @param array $data
     *
     * @return void
     */
    public function update(Film $film, array $data): void
    {
        $film->update($data);
    }

    /**
     * Привязывает жанры к фильму
     *
     * @param Film   $film
     * @param array  $genreIds
     * @return void
     */
    public function syncGenres(Film $film, array $genreIds): void
    {
        $film->genres()->sync($genreIds);
    }

    /**
     * Привязывает актёров к фильму
     *
     * @param Film   $film
     * @param array  $actorIds
     * @return void
     */
    public function syncActors(Film $film, array $actorIds): void
    {
        $film->actors()->sync($actorIds);
    }

    /**
     * Загружает связи
     *
     * @param Film $film
     * @return Film
     */
    public function loadRelations(Film $film): Film
    {
        return $film->load('genres', 'actors', 'directors');
    }

    /**
     * Ищет фильм по ID
     *
     * @param int $id
     *
     * @return Film
     */
    public function findOrFail(int $id): Film
    {
        return Film::findOrFail($id);
    }

    /**
     * Получить похожие фильмы по жанрам фильма с заданным id
     *
     * @param int $filmId
     * @param int $limit
     *
     * @return Collection
     *
     * @psalm-return Collection<int, Film>
     */
    public function getSimilarFilmsByGenres(int $filmId, int $limit = 4): Collection
    {
        $film = $this->findOrFail($filmId);

        return Film::with(['genres'])
            ->whereHas('genres', function ($query) use ($film) {
                $query->whereIn('genres.id', $film->genres->pluck('id'));
            })
            ->where('id', '!=', $film->id)
            ->orderBy('released', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Получить текущий промо-фильм
     *
     * @return Film
     */
    public function getPromoFilm(): Film
    {
        return Film::where('is_promo', true)
            ->with(['genres', 'actors', 'directors'])
            ->firstOrFail();
    }

    /**
     * Сбросить флаг is_promo у всех фильмов
     *
     * @return int Число обновленных записей
     */
    public function resetPromoFlags(): int
    {
        return Film::where('is_promo', true)->update(['is_promo' => false]);
    }

    /**
     * Установить флаг is_promo для фильма по ID
     *
     * @param int $filmId
     * @return int Количество обновленных записей (должно быть 1)
     */
    public function setPromoFlag(int $filmId): int
    {
        return Film::where('id', $filmId)->update(['is_promo' => true]);
    }
}
