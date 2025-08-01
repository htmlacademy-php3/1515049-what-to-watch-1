<?php

namespace App\Http\Resources;

use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * Ресурс для представления данных фильма.
 *
 * @property int         $id
 * @property string      $name
 * @property string|null $poster_image
 * @property string|null $preview_image
 * @property string|null $background_image
 * @property string|null $background_color
 * @property string|null $video_link
 * @property string|null $preview_video_link
 * @property string|null $description
 * @property float|null  $rating
 * @property int|null    $imdb_votes
 * @property Collection $directors
 * @property Collection $actors
 * @property Collection $genres
 * @property int|null    $run_time
 * @property int|null    $released
 * @property bool|null   $is_favorite
 *
 * @mixin Film
 */
class FilmResource extends JsonResource
{
    /**
     * Преобразует ресурс в массив.
     *
     * @param Request $request
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'poster_image' => $this->poster_image,
            'preview_image' => $this->preview_image,
            'background_image' => $this->background_image,
            'background_color' => $this->background_color,
            'video_link' => $this->video_link,
            'preview_video_link' => $this->preview_video_link,
            'description' => $this->description,
            'rating' => $this->rating ?? 0,
            'scores_count' => $this->imdb_votes ?? 0,
            'director' => $this->directors->pluck('name')->first(),
            'starring' => $this->actors->pluck('name')->all(),
            'run_time' => (int)$this->run_time,
            'genre' => $this->genres->pluck('name')->first(),
            'released' => (int)$this->released,
            'is_favorite' => $this->when(
                isset($this->is_favorite),
                $this->is_favorite,
                false
            ),
            'is_promo' => $this->is_promo === true,
        ];
    }
}
