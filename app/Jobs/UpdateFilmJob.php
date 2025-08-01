<?php

namespace App\Jobs;

use App\Models\Actor;
use App\Models\Director;
use App\Models\Film;
use App\Models\Genre;
use App\Services\OmdbFilmsService;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateFilmJob implements ShouldQueue
{
    use Queueable;
    use interactsWithQueue;
    use SerializesModels;

    private string $imdbId;

    /**
     * Create a new job instance.
     */
    public function __construct(string $imdbId, public Film $film)
    {
        $this->imdbId = $imdbId;
    }

    /**
     * Execute the job.
     *
     * @throws Exception
     */
    public function handle(OmdbFilmsService $service): void
    {
        $data = $service->getFilm($this->imdbId);

        $film = Film::updateOrCreate(
            ['imdb_id' => $data['imdbID'] ?? null],
            [
                'name' => $data['Title'] ?? '',
                'description' => $data['Plot'] ?? '',
                'run_time' => $this->parseRuntime($data['Runtime'] ?? ''),
                'released' => $data['Year'] ?? null,
                'rating' => ($data['imdbRating'] === 'N/A') ? null : $data['imdbRating'],
                'poster_image' => $data['Poster'] ?? '',
                'imdb_votes' => (int) str_replace(',', '', $data['imdbVotes']) ?? null,
            ]
        );

        $this->syncRelations($film, $data);
    }

    /**
     * Преобразует "142 min" в 142
     *
     * @param string $runtime
     *
     * @return int
     */
    private function parseRuntime(string $runtime): int
    {
        if (preg_match('/(\d+)\s*min/', $runtime, $matches)) {
            return (int)$matches[1];
        }

        return 0;
    }

    private function syncRelations(Film $film, array $data): void
    {
        if (!empty($data['Director'])) {
            $directorNames = explode(',', $data['Director']);
            $directorIds = collect($directorNames)->map(function ($name) {
                return Director::firstOrCreate(['name' => trim($name)])->id;
            });
            $film->directors()->sync($directorIds);
        }

        if (!empty($data['Actors'])) {
            $actorNames = explode(',', $data['Actors']);
            $actorIds = collect($actorNames)->map(function ($name) {
                return Actor::firstOrCreate(['name' => trim($name)])->id;
            });
            $film->actors()->sync($actorIds);
        }

        if (!empty($data['Genre'])) {
            $genreNames = explode(',', $data['Genre']);
            $genreIds = collect($genreNames)->map(function ($name) {
                return Genre::firstOrCreate(['name' => trim($name)])->id;
            });
            $film->genres()->sync($genreIds);
        }
    }
}
