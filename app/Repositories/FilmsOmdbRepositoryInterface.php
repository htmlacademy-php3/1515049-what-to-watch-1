<?php

namespace App\Repositories;

interface FilmsOmdbRepositoryInterface
{
    public function getFilmById(string $imdbId): ?array;

    public function getError(): string;
}
