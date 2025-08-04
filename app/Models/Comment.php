<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Class Comment
 *
 * @package App\Models
 * @property int                           $id
 * @property string                        $text
 * @property string                        $author
 * @property int|null                      $rate
 * @property int|null                      $comment_id
 * @property int                           $user_id
 * @property int                           $film_id
 * @property Carbon|null                   $created_at
 * @property Carbon|null                   $updated_at
 * @property-read Comment|null             $comment
 * @property-read Collection<int, Comment> $comments
 * @property-read int|null                 $comments_count
 * @property-read Film                     $film
 * @property-read User                     $user
 * @method static Builder<static>|Comment newModelQuery()
 * @method static Builder<static>|Comment newQuery()
 * @method static Builder<static>|Comment query()
 * @method static Builder<static>|Comment whereAuthor($value)
 * @method static Builder<static>|Comment whereCommentId($value)
 * @method static Builder<static>|Comment whereContent($value)
 * @method static Builder<static>|Comment whereCreatedAt($value)
 * @method static Builder<static>|Comment whereFilmId($value)
 * @method static Builder<static>|Comment whereId($value)
 * @method static Builder<static>|Comment whereRate($value)
 * @method static Builder<static>|Comment whereUpdatedAt($value)
 * @method static Builder<static>|Comment whereUserId($value)
 * @mixin \Eloquent
 */
class Comment extends Model
{
    use HasFactory;

    public const string DEFAULT_AUTHOR_NAME = "Гость";

    protected string $table = 'comments';

    /**
     * @var string[]
     *
     * @psalm-var array{rate: 'int', comment_id: 'int', user_id: 'int', film_id: 'int'}
     */
    protected array $casts = [
        'rate' => 'int',
        'comment_id' => 'int',
        'user_id' => 'int',
        'film_id' => 'int'
    ];

    /**
     * @var string[]
     *
     * @psalm-var list{'text', 'author', 'rate', 'comment_id', 'user_id', 'film_id'}
     */
    protected array $fillable = [
        'text',
        'author',
        'rate',
        'comment_id',
        'user_id',
        'film_id'
    ];

    /**
     * Ответы на этот комментарий (дочерние)
     *
     * @psalm-return HasMany<self>
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'comment_id');
    }

    /**
     * Удаление комментария с ответами
     *
     * @return bool|null
     */
    public function deleteWithReplies(): ?bool
    {
        $this->replies->each->deleteWithReplies();

        return $this->delete();
    }
}
