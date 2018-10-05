<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Studios extends Model
{
    //
    protected $primaryKey = 'studio_id';
    protected $fillable = ['studio_name'];

    public function movies()
    {
        return $this->hasMany('App\Movies', 'movie_id', 'studio_id');
    }
}
