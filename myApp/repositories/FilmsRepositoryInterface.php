<?php

namespace myApp\repositories;

interface FilmsRepositoryInterface
{
  public function getFilmById(string $imdbId): ?array;
}
