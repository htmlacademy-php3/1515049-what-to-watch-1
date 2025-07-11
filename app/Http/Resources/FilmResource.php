<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

final class FilmResource extends JsonResource
{
    public function toArray($request): array
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
            'rating' => $this->rating,
            'scores_count' => $this->imdb_votes,
            'director' => $this->directors->pluck('name')->first(),
            'starring' => $this->actors->pluck('name')->all(),
            'run_time' => (int)$this->run_time,
            'genre' => $this->genres->pluck('name')->first(),
            'released' => (int)$this->released,
            'is_favorite' => (bool) $this->is_favorite ?? false,
        ];
    }
}
