<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Job
 *
 * @package App\Models
 * @property int $id
 * @property string $queue
 * @property string $payload
 * @property int $attempts
 * @property int|null $reserved_at
 * @property int $available_at
 * @property int $created_at
 * @method static Builder<static>|Job newModelQuery()
 * @method static Builder<static>|Job newQuery()
 * @method static Builder<static>|Job query()
 * @method static Builder<static>|Job whereAttempts($value)
 * @method static Builder<static>|Job whereAvailableAt($value)
 * @method static Builder<static>|Job whereCreatedAt($value)
 * @method static Builder<static>|Job whereId($value)
 * @method static Builder<static>|Job wherePayload($value)
 * @method static Builder<static>|Job whereQueue($value)
 * @method static Builder<static>|Job whereReservedAt($value)
 * @mixin \Eloquent
 */
class Job extends Model
{
	protected string $table = 'jobs';

	/**
	 * @var false
	 */
	public bool $timestamps = false;

	/**
	 * @var string[]
	 *
	 * @psalm-var array{attempts: 'int', reserved_at: 'int', available_at: 'int'}
	 */
	protected array $casts = [
		'attempts' => 'int',
		'reserved_at' => 'int',
		'available_at' => 'int'
	];

	/**
	 * @var string[]
	 *
	 * @psalm-var list{'queue', 'payload', 'attempts', 'reserved_at', 'available_at'}
	 */
	protected array $fillable = [
		'queue',
		'payload',
		'attempts',
		'reserved_at',
		'available_at'
	];
}
