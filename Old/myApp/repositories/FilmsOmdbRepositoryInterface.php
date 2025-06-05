<?php

namespace myApp\repositories;

interface FilmsOmdbRepositoryInterface
{
  public function getFilmById(string $imdbId): ?array;

  public function getError() : string;
}
