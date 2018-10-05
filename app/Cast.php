<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cast extends Model
{
    //
    protected $table = 'casts';
    protected $primaryKey = 'cast_id';
    protected $fillable = ['movie_id', 'character', 'star','person_id'];
}
