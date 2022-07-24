<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['title'];

    public function photos(){
        return $this->morphMany('App\Photo','imageable');
    }

    //many to many
    public function photos(){
        return $this->morphToMany('App\Photo','imageable');
    }
}
