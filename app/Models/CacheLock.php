<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
 * @mixin \Eloquent
 */
class CacheLock extends Model
{
    protected string $table = 'cache_locks';
    protected string $primaryKey = 'key';

    /**
     * @var false
     */
    public bool $incrementing = false;

    /**
     * @var false
     */
    public bool $timestamps = false;

    /**
     * @var string[]
     *
     * @psalm-var array{expiration: 'int'}
     */
    protected array $casts = [
        'expiration' => 'int'
    ];

    /**
     * @var string[]
     *
     * @psalm-var list{'owner', 'expiration'}
     */
    protected array $fillable = [
        'owner',
        'expiration'
    ];
}
