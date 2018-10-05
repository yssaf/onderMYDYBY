<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    protected $table = 'tags';
    protected $primaryKey = 'tag_id';
    protected $fillable = ['movie_id', 'keyword_id'];
}
