<?php

namespace App\Http\Resources;

use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * Ресурс для краткого представления фильма в списке.
 *
 * @property int                             $id
 * @property string                          $name
 * @property string|null                     $poster_image
 * @property string|null                     $preview_image
 * @property string|null                     $preview_video_link
 * @property Collection  $genres
 * @property int|null                        $released
 *
 * @mixin Film
 */
final class FilmListResource extends JsonResource
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
            'preview_video_link' => $this->preview_video_link,
            'genre' => $this->genres->pluck('name')->first(),
            'released' => (int)$this->released,
        ];
    }
}
