<?php

namespace App\Services;

use App\Models\FavoriteFilm;
use App\Models\Film;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * Сервис для работы с фильмами.
 *
 * Предоставляет методы для получения списка фильмов с фильтрацией и
 * получения подробной информации о конкретном фильме.
 */
class FilmService
{
    /**
     * Проверяет, есть ли фильм в избранном у пользователя
     */
    public function isFavorite(int $filmId, int $userId): bool
    {
        return FavoriteFilm::where([
            'film_id' => $filmId,
            'user_id' => $userId
        ])->exists();
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
        $films = Film::query()->with(
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

        if ($userId) {
            $films->getCollection()->transform(function ($film) use ($userId) {
                $film->is_favorite = $this->isFavorite($film->id, $userId);
                return $film;
            });
        }

        return $films;
    }

    /**
     *  Возвращает подробную информацию о фильме по его ID с отметкой об избранном.
     *
     * @param int $id ID фильма
     *
     * @return Film Модель фильма со связями
     */
    public function getFilmDetails(int $id, ?int $userId = null): Film
    {
        return Film::with([
            'genres',
            'actors',
            'directors',
            'favorites' => fn ($q) => $userId ? $q->where('user_id', $userId) : $q
        ])->findOrFail($id);
    }

    /**
     * Создает новый фильм
     *
     * @throws Throwable
     */
    public function createFilm(array $data): Film
    {
        return DB::transaction(function () use ($data) {
            $film =
                Film::create($data);

            if (isset($data['genre_id'])) {
                $film->genres()->sync($data['genre_id']);
            }

            if (isset($data['actor_id'])) {
                $film->actors()->sync($data['actor_id']);
            }

            return $film->load('genres', 'actors', 'directors');
        });
    }

    /**
     * Обновляет данные фильма
     *
     * @throws Throwable
     */
    public function updateFilm(int $id, array $data): Film
    {
        return DB::transaction(function () use ($id, $data) {
            $film =
                Film::findOrFail($id);

            $film->update([
                'name' => $data['name'] ?? $film->name,
                'description' => $data['description'] ?? $film->description,
                'rating' => $data['rating'] ?? $film->rating,
                'released' => $data['released'] ?? $film->released,
                'run_time' => $data['run_time'] ?? $film->run_time,
                'background_color' => $data['background_color'] ?? $film->background_color,
                'poster_image' => $data['poster_image'] ?? $film->poster_image,
                'preview_image' => $data['preview_image'] ?? $film->preview_image,
                'background_image' => $data['background_image'] ?? $film->background_image,
                'video_link' => $data['video_link'] ?? $film->video_link,
                'preview_video_link' => $data['preview_video_link'] ?? $film->preview_video_link,
                'imdb_votes' => $data['imdb_votes'] ?? $film->imdb_votes,
            ]);

            if (isset($data['genre_id'])) {
                $film->genres()->sync($data['genre_id']);
            }

            if (isset($data['actor_id'])) {
                $film->actors()->sync($data['actor_id']);
            }

            return $film->load('genres', 'actors', 'directors');
        });
    }

    /**
     * Получает похожие фильмы по жанру выбранного фильма
     */
    public function getSimilarFilms(int $id): Collection
    {
        $film = Film::findOrFail($id);

        return Film::with(['genres'])
            ->whereHas('genres', function ($query) use ($film) {
                $query->whereIn('genres.id', $film->genres->pluck('id'));
            })
        ->where('id', '!=', $film->id)
    ->orderBy('released', 'desc')
    ->limit(4)
    ->get();
    }

    /**
     * Получает текущий промо фильм
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
     * Устанавливает фильм как промо и снимает флаг с предыдущего
     *
     * @throws Throwable
     */
    public function setPromoFilm(int $filmId): Film
    {
        DB::transaction(function () use ($filmId) {
            Film::where('is_promo', true)->update(['is_promo' => false]);
            Film::where('id', $filmId)->update(['is_promo' => true]);
        });

        return $this->getFilmDetails($filmId);
    }
}
