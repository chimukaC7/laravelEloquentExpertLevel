<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{

    protected $fillable = ['imageable_id','imageable_type','filename'];

    //this is for polymorphic
    public function imageable(){//name should match the prefix of the id
        return $this->morphTo();
    }

    ///this is for many to many polymorphic
    /// you create a seperate method for every relationship
    public function products(){
        return $this->morphedByMany('App\Product','imageable');
    }

    public function posts(){
        return $this->morphedByMany('App\Post', 'imageable');
    }
}
