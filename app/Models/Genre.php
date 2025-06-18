<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Genre
 * 
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Film[] $films
 *
 * @package App\Models
 */
class Genre extends Model
{
	protected $table = 'genres';

	protected $fillable = [
		'name'
	];

	public function films()
	{
		return $this->belongsToMany(Film::class, 'genre_films');
	}
}
