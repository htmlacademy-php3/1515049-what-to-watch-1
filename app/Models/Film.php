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
 * @property string                             $name
 * @property string|null                        $released
 * @property string|null                        $description
 * @property string|null                        $director
 * @property string|null                        $run_time
 * @property float|null                         $rating
 * @property int|null                           $imdb_votes
 * @property string|null                        $imdb_id
 * @property string|null                        $poster_image
 * @property string|null                        $preview_image
 * @property string|null                        $background_image
 * @property string|null                        $background_color
 * @property string|null                        $video_link
 * @property string|null                        $preview_video_link
 * @property Carbon|null                        $created_at
 * @property Carbon|null                        $updated_at
 * @property-read Collection<int, Comment>      $comments
 * @property-read int|null                      $comments_count
 * @property-read Collection<int, FavoriteFilm> $favorite_films
 * @property-read int|null                      $favorite_films_count
 * @property-read Collection<int, Genre>        $genres
 * @property-read int|null                      $genres_count
 * @property-read float|null                    $calculated_rating Средняя оценка по комментариям (accessor)
 * @method static Builder|Film whereName($value)
 * @method static Builder|Film whereReleased($value)
 * @method static Builder|Film whereRunTime($value)
 * @method static Builder|Film wherePosterImage($value)
 * @method static Builder|Film wherePreviewImage($value)
 * @method static Builder|Film whereBackgroundImage($value)
 * @method static Builder|Film whereVideoLink($value)
 * @method static Builder|Film wherePreviewVideoLink($value)
 * @mixin Eloquent
 */
class Film extends Model
{
    use HasFactory;

    public const string STATUS_PENDING = 'pending';
    public const string STATUS_MODERATE = 'moderate';
    public const string STATUS_READY = 'ready';
    /**
     * @var bool|mixed
     */
    public bool $is_favorite = false;

    protected string $table = 'films';

    /**
     * @var string[]
     *
     * @psalm-var list{'name', 'status', 'released', 'description', 'director', 'run_time', 'rating', 'imdb_votes', 'imdb_id', 'poster_image', 'preview_image', 'background_image', 'background_color', 'video_link', 'preview_video_link', 'is_promo'}
     */
    protected array $fillable = [
        'name',
        'status',
        'released',
        'description',
        'director',
        'run_time',
        'rating',
        'imdb_votes',
        'imdb_id',
        'poster_image',
        'preview_image',
        'background_image',
        'background_color',
        'video_link',
        'preview_video_link',
        'is_promo',
    ];

    /**
     * @var string[]
     *
     * @psalm-var array{rating: 'float', imdb_votes: 'integer', is_promo: 'boolean'}
     */
    protected array $casts = [
        'rating' => 'float',
        'imdb_votes' => 'integer',
        'is_promo' => 'boolean',
    ];

    /**
     * Получить все комментарии, связанные с фильмом.
     *
     * @return HasMany
     *
     * @psalm-return HasMany<Comment>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Получить жанры, к которым относится фильм.
     *
     * @return BelongsToMany
     *
     * @psalm-return BelongsToMany<Genre>
     */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'genre_film');
    }

    /**
     * Получить актёров, участвующих в фильме.
     *
     * @return BelongsToMany
     *
     * @psalm-return BelongsToMany<Actor>
     */
    public function actors(): BelongsToMany
    {
        return $this->belongsToMany(Actor::class, 'actor_film');
    }

    /**
     * Получить режиссёров, снявших фильм.
     *
     * @return BelongsToMany
     *
     * @psalm-return BelongsToMany<Director>
     */
    public function directors(): BelongsToMany
    {
        return $this->belongsToMany(Director::class, 'director_film');
    }
}
