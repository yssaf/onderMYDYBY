<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Crew extends Model
{
    //
    protected $table = 'crews';
    protected $primaryKey = 'crew_id';
    protected $fillable = ['movie_id', 'person_id', 'position'];
}
