<?php

namespace App\Services;

use App\Repositories\FilmsOmdbRepositoryInterface;

final class OmdbFilmsService
{
    private FilmsOmdbRepositoryInterface $repository;

    public function __construct(FilmsOmdbRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getFilm(string $imdbId): array
    {
        $filmData = $this->repository->getFilmById($imdbId);

        if (!$filmData) {
            echo $this->repository->getError();
            return [];
        }

        return $filmData;
    }
}
