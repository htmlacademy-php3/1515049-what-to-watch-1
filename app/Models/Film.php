<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Class Film
 *
 * @package App\Models
 * @property int                                $id
 * @property string                             $title
 * @property string|null                        $year
 * @property string|null                        $description
 * @property string|null                        $director
 * @property string|null                        $actors
 * @property string|null                        $duration
 * @property float|null                         $imdb_rating
 * @property int|null                           $imdb_votes
 * @property string|null                        $imdb_id
 * @property string|null                        $poster_url
 * @property string|null                        $preview_url
 * @property string|null                        $background_color
 * @property string|null                        $cover_url
 * @property string|null                        $video_url
 * @property string|null                        $video_preview_url
 * @property Carbon|null                        $created_at
 * @property Carbon|null                        $updated_at
 * @property-read Collection<int, Comment>      $comments
 * @property-read int|null                      $comments_count
 * @property-read Collection<int, FavoriteFilm> $favorite_films
 * @property-read int|null                      $favorite_films_count
 * @property-read Collection<int, Genre>        $genres
 * @property-read int|null                      $genres_count
 * @property-read float|null                    $rating Средняя оценка фильма по комментариям
 * @method static Builder<static>|Film newModelQuery()
 * @method static Builder<static>|Film newQuery()
 * @method static Builder<static>|Film query()
 * @method static Builder<static>|Film whereActors($value)
 * @method static Builder<static>|Film whereBackgroundColor($value)
 * @method static Builder<static>|Film whereCoverUrl($value)
 * @method static Builder<static>|Film whereCreatedAt($value)
 * @method static Builder<static>|Film whereDescription($value)
 * @method static Builder<static>|Film whereDirector($value)
 * @method static Builder<static>|Film whereDuration($value)
 * @method static Builder<static>|Film whereId($value)
 * @method static Builder<static>|Film whereImdbId($value)
 * @method static Builder<static>|Film whereImdbRating($value)
 * @method static Builder<static>|Film whereImdbVotes($value)
 * @method static Builder<static>|Film wherePosterUrl($value)
 * @method static Builder<static>|Film wherePreviewUrl($value)
 * @method static Builder<static>|Film whereTitle($value)
 * @method static Builder<static>|Film whereUpdatedAt($value)
 * @method static Builder<static>|Film whereVideoPreviewUrl($value)
 * @method static Builder<static>|Film whereVideoUrl($value)
 * @method static Builder<static>|Film whereYear($value)
 * @mixin Eloquent
 */
class Film extends Model
{
    use HasFactory;

    protected $table = 'films';

    protected $casts = [
        'imdb_rating' => 'float',
        'imdb_votes' => 'int'
    ];

    protected $fillable = [
        'title',
        'year',
        'description',
        'director',
        'duration',
        'imdb_rating',
        'imdb_votes',
        'imdb_id',
        'poster_url',
        'preview_url',
        'background_color',
        'cover_url',
        'video_url',
        'video_preview_url'
    ];

    /**
     * Получить все комментарии, связанные с фильмом.
     *
     * @return HasMany
     */
    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Получить все записи об избранных фильмах, в которых указан этот фильм.
     *
     * @return HasMany
     */
    public function favoriteFilms() : HasMany
    {
        return $this->hasMany(FavoriteFilm::class);
    }

    /**
     * Получить всех пользователей, добавивших фильм в избранное.
     *
     * @return BelongsToMany
     */
    public function usersWhoFavorited() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorite_films', 'film_id', 'user_id')->withTimestamps();
    }

    /**
     * Получить жанры, к которым относится фильм.
     *
     * @return BelongsToMany
     */
    public function genres() : BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'genre_film');
    }

    /**
     * Получить актёров, участвующих в фильме.
     *
     * @return BelongsToMany
     */
    public function actors() : BelongsToMany
    {
        return $this->belongsToMany(Actor::class, 'actor_film');
    }

    /**
     * Получить режиссёров, снявших фильм.
     *
     * @return BelongsToMany
     */
    public function directors() : BelongsToMany
    {
        return $this->belongsToMany(Director::class, 'director_film');
    }

    /**
     * Получить среднюю оценку фильма на основе пользовательских комментариев.
     *
     * @return float|null
     */
    public function getRatingAttribute() : ?float
    {
        $avg =
            $this->comments()->avg('rate');

        return $avg !== null ? round($avg, 1) : null;
    }
}
