<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GenreFilm
 * 
 * @property int $film_id
 * @property int $genre_id
 * 
 * @property Film $film
 * @property Genre $genre
 *
 * @package App\Models
 */
class GenreFilm extends Model
{
	protected $table = 'genre_films';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'film_id' => 'int',
		'genre_id' => 'int'
	];

	public function film()
	{
		return $this->belongsTo(Film::class);
	}

	public function genre()
	{
		return $this->belongsTo(Genre::class);
	}
}
