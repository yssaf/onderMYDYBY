<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forms extends Model
{
    //
    protected $table = 'forms';
    protected $fillable = ['name', 'field', 'label', 'required', 'type', 'order', 'range_from', 'range_to', 'options', 'default', 'class'];
    protected $primaryKey = 'id';
    public $timestamps = false;

    public static function getFormFields($name, $withFiles = true){
        $query = Forms::where('name', $name);
        if(!$withFiles) $query->where('type', '!=', 'file');
        $query->orderBy('order', 'ASC');
        return $query->get();
    }

}
