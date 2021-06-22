<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionModel extends Model
{
    protected $table = 'sessions';
    protected $primaryKey = 'id';

    protected $fillable = ['movie_id', 'date_time', 'hall_size'];
}
