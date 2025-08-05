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
 * Class Session
 *
 * @package App\Models
 * @property string $id
 * @property int|null $user_id
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property string $payload
 * @property int $last_activity
 * @method static Builder<static>|Session newModelQuery()
 * @method static Builder<static>|Session newQuery()
 * @method static Builder<static>|Session query()
 * @method static Builder<static>|Session whereId($value)
 * @method static Builder<static>|Session whereIpAddress($value)
 * @method static Builder<static>|Session whereLastActivity($value)
 * @method static Builder<static>|Session wherePayload($value)
 * @method static Builder<static>|Session whereUserAgent($value)
 * @method static Builder<static>|Session whereUserId($value)
 * @method static Collection|static[] pluck(string $column, string|null $key = null)
 * @method static Model|static findOrFail(int $id)
 * @method static Model|static firstOrCreate(array $attributes, array $values = [])
 * @mixin Eloquent
 */
class Session extends Model
{
    protected $table = 'sessions';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'user_id' => 'int',
        'last_activity' => 'int'
    ];

    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'payload',
        'last_activity'
    ];
}
