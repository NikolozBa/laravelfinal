<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieModel extends Model
{
    protected $table = 'movies';
    protected $primaryKey = 'id';

    protected $fillable = ['title', 'description', 'categories', 'poster', 'availability'];
}
