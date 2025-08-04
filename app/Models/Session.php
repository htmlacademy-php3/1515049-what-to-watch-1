<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
 * @mixin \Eloquent
 */
class Session extends Model
{
	protected string $table = 'sessions';

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
	 * @psalm-var array{user_id: 'int', last_activity: 'int'}
	 */
	protected array $casts = [
		'user_id' => 'int',
		'last_activity' => 'int'
	];

	/**
	 * @var string[]
	 *
	 * @psalm-var list{'user_id', 'ip_address', 'user_agent', 'payload', 'last_activity'}
	 */
	protected array $fillable = [
		'user_id',
		'ip_address',
		'user_agent',
		'payload',
		'last_activity'
	];
}
