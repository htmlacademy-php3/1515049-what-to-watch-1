<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

final class FilmListResource extends JsonResource
{
    public function toArray($request): array
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
