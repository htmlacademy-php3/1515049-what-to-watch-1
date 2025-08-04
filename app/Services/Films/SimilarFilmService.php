<?php

namespace App\Services\Films;

use App\Repositories\Films\FilmRepository;
use Illuminate\Database\Eloquent\Collection;

/**
 * Сервис получения похожих фильмов
 */
class SimilarFilmService
{


    /**
     * Получает похожие фильмы по жанру выбранного фильма
     */
    public function getSimilarFilms(int $id): Collection
    {
        return $this->filmRepository->getSimilarFilmsByGenres($id, 4);
    }
}
