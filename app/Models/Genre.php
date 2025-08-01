<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * Class Genre
 *
 * @package App\Models
 * @property int                        $id
 * @property string                     $name
 * @property Carbon|null                $created_at
 * @property Carbon|null                $updated_at
 * @property-read Collection<int, Film> $films
 * @property-read int|null              $films_count
 * @method static Builder<static>|Genre newModelQuery()
 * @method static Builder<static>|Genre newQuery()
 * @method static Builder<static>|Genre query()
 * @method static Builder<static>|Genre whereCreatedAt($value)
 * @method static Builder<static>|Genre whereId($value)
 * @method static Builder<static>|Genre whereName($value)
 * @method static Builder<static>|Genre whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Genre extends Model
{
    use HasFactory;

    protected $table = 'genres';

    protected $fillable = [
        'name'
    ];

    public function films(): BelongsToMany
    {
        return $this->belongsToMany(Film::class, 'genre_film');
    }
}
