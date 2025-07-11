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
	protected $table = 'jobs';
	public $timestamps = false;

	protected $casts = [
		'attempts' => 'int',
		'reserved_at' => 'int',
		'available_at' => 'int'
	];

	protected $fillable = [
		'queue',
		'payload',
		'attempts',
		'reserved_at',
		'available_at'
	];
}
