<?php

namespace App\Models;

use Eloquent;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 *
 * @package App\Models
 * @property int                                $id
 * @property int                                $role
 * @property string|null                        $avatar
 * @property string                             $name
 * @property string                             $email
 * @property Carbon|null                        $email_verified_at
 * @property string                             $password
 * @property string|null                        $remember_token
 * @property Carbon|null                        $created_at
 * @property Carbon|null                        $updated_at
 * @property-read Collection<int, Comment>      $comments
 * @property-read int|null                      $comments_count
 * @property-read Collection<int, FavoriteFilm> $favorite_films
 * @property-read int|null                      $favorite_films_count
 * @method static Builder<static>|User newModelQuery()
 * @method static Builder<static>|User newQuery()
 * @method static Builder<static>|User query()
 * @method static Builder<static>|User whereAvatar($value)
 * @method static Builder<static>|User whereCreatedAt($value)
 * @method static Builder<static>|User whereEmail($value)
 * @method static Builder<static>|User whereEmailVerifiedAt($value)
 * @method static Builder<static>|User whereId($value)
 * @method static Builder<static>|User whereName($value)
 * @method static Builder<static>|User wherePassword($value)
 * @method static Builder<static>|User whereRememberToken($value)
 * @method static Builder<static>|User whereRole($value)
 * @method static Builder<static>|User whereUpdatedAt($value)
 * @mixin Eloquent
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    public const int ROLE_USER = 1;
    public const int ROLE_MODERATOR = 2;

    protected string $table = 'users';

    /**
     * @var string[]
     *
     * @psalm-var array{email_verified_at: 'datetime', role: 'integer'}
     */
    protected array $casts = [
        'email_verified_at' => 'datetime',
        'role' => 'integer',
    ];

    /**
     * @var string[]
     *
     * @psalm-var list{'password', 'remember_token'}
     */
    protected array $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * @var string[]
     *
     * @psalm-var list{'role', 'avatar', 'name', 'email', 'email_verified_at', 'password', 'remember_token'}
     */
    protected array $fillable = [
        'role',
        'avatar',
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token'
    ];

    /**
     * @psalm-return HasMany<Comment>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @psalm-return BelongsToMany<Film>
     */
    public function favoriteFilms(): BelongsToMany
    {
        return $this->belongsToMany(Film::class, 'favorite_films')
            ->withTimestamps();
    }

    public function isModerator(): bool
    {
        return $this->role === self::ROLE_MODERATOR;
    }

    public function getAvatarUrlAttribute(): ?string
    {
        return $this->avatar ? asset("storage/{$this->avatar}") : null;
    }
}
