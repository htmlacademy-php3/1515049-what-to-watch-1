<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 * 
 * @property int $id
 * @property string $content
 * @property string $author
 * @property int|null $rate
 * @property int|null $comment_id
 * @property int $user_id
 * @property int $film_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Comment|null $comment
 * @property Film $film
 * @property User $user
 * @property Collection|Comment[] $comments
 *
 * @package App\Models
 */
class Comment extends Model
{
	protected $table = 'comments';

	protected $casts = [
		'rate' => 'int',
		'comment_id' => 'int',
		'user_id' => 'int',
		'film_id' => 'int'
	];

	protected $fillable = [
		'content',
		'author',
		'rate',
		'comment_id',
		'user_id',
		'film_id'
	];

	public function comment()
	{
		return $this->belongsTo(Comment::class);
	}

	public function film()
	{
		return $this->belongsTo(Film::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function comments()
	{
		return $this->hasMany(Comment::class);
	}
}
