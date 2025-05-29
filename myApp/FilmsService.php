<?php

namespace myApp;

use myApp\repositories\FilmsRepositoryInterface;

final class FilmsService
{
  private FilmsRepositoryInterface $repository;

  public function __construct(FilmsRepositoryInterface $repository)
  {
    $this->repository = $repository;
  }

  public function getFilm(string $imdbId): array
  {
    return $this->repository->getFilmById($imdbId);
  }
}
