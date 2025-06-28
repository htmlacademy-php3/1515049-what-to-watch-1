<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Director extends Model
{
    protected $fillable = ['name'];

    public function films(): BelongsToMany
    {
        return $this->belongsToMany(Film::class, 'director_film');
    }
}
