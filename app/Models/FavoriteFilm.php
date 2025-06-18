<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FavoriteFilm
 * 
 * @property int $id
 * @property int $user_id
 * @property int $film_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Film $film
 * @property User $user
 *
 * @package App\Models
 */
class FavoriteFilm extends Model
{
	protected $table = 'favorite_films';

	protected $casts = [
		'user_id' => 'int',
		'film_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'film_id'
	];

	public function film()
	{
		return $this->belongsTo(Film::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
