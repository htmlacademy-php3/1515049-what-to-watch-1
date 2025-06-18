<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Film
 * 
 * @property int $id
 * @property string $title
 * @property string|null $year
 * @property string|null $description
 * @property string|null $director
 * @property string|null $actors
 * @property string|null $duration
 * @property float|null $imdb_rating
 * @property int|null $imdb_votes
 * @property string|null $imdb_id
 * @property string|null $poster_url
 * @property string|null $preview_url
 * @property string|null $background_color
 * @property string|null $cover_url
 * @property string|null $video_url
 * @property string|null $video_preview_url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Comment[] $comments
 * @property Collection|FavoriteFilm[] $favorite_films
 * @property Collection|Genre[] $genres
 *
 * @package App\Models
 */
class Film extends Model
{
	protected $table = 'films';

	protected $casts = [
		'imdb_rating' => 'float',
		'imdb_votes' => 'int'
	];

	protected $fillable = [
		'title',
		'year',
		'description',
		'director',
		'actors',
		'duration',
		'imdb_rating',
		'imdb_votes',
		'imdb_id',
		'poster_url',
		'preview_url',
		'background_color',
		'cover_url',
		'video_url',
		'video_preview_url'
	];

	public function comments()
	{
		return $this->hasMany(Comment::class);
	}

	public function favorite_films()
	{
		return $this->hasMany(FavoriteFilm::class);
	}

	public function genres()
	{
		return $this->belongsToMany(Genre::class, 'genre_films');
	}
}
