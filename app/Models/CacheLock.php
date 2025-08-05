<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CacheLock
 *
 * @package App\Models
 * @property string $key
 * @property string $owner
 * @property int    $expiration
 * @method static Builder<static>|CacheLock newModelQuery()
 * @method static Builder<static>|CacheLock newQuery()
 * @method static Builder<static>|CacheLock query()
 * @method static Builder<static>|CacheLock whereExpiration($value)
 * @method static Builder<static>|CacheLock whereKey($value)
 * @method static Builder<static>|CacheLock whereOwner($value)
 * @method static Collection|static[] pluck(string $column, string|null $key = null)
 * @method static Model|static findOrFail(int $id)
 * @method static Model|static firstOrCreate(array $attributes, array $values = [])
 * @mixin Eloquent
 */
class CacheLock extends Model
{
    protected $table = 'cache_locks';
    protected $primaryKey = 'key';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'expiration' => 'int'
    ];

    protected $fillable = [
        'owner',
        'expiration'
    ];
}
