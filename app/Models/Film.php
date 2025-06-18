<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $title
 * @property string|null $year
 * @property string|null $description
 * @property string|null $director
 * @property string|null $actors
 * @property string|null $duration
 * @property string|null $imdb_rating
 * @property int|null $imdb_votes
 * @property string|null $imdb_id
 * @property string|null $poster_url
 * @property string|null $preview_url
 * @property string|null $background_color
 * @property string|null $cover_url
 * @property string|null $video_url
 * @property string|null $video_preview_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Film newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Film newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Film query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Film whereActors($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Film whereBackgroundColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Film whereCoverUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Film whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Film whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Film whereDirector($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Film whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Film whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Film whereImdbId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Film whereImdbRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Film whereImdbVotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Film wherePosterUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Film wherePreviewUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Film whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Film whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Film whereVideoPreviewUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Film whereVideoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Film whereYear($value)
 * @mixin \Eloquent
 */
class Film extends Model
{
    //
}
