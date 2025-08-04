<?php

declare(strict_types=1);

namespace App\Repositories\Films;

use App\Models\Film;

final class FilmDetailsRepository
{
    public function details(int $id, ?int $userId = null): Film
    {
        return Film::with([
            'genres',
            'actors',
            'directors',
            'favorites' => fn ($q) => $userId ? $q->where('user_id', $userId) : $q
        ])->findOrFail($id);
    }
}
